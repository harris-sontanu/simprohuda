<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Exports\UsersExport;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    protected $roles = [
        'administrator' => 'Administrator',
        'bagianhukum' => 'Bagian Hukum',
        'opd' => 'Perangkat Daerah'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageHeader = 'Operator';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Operator',
            'Daftar' => TRUE
        ];

        $onlyTrashed = FALSE;
        if ($tab = $request->tab AND $tab == 'trash') {
            $users = User::onlyTrashed();
            $onlyTrashed = TRUE;
        } else if ($tab = $request->tab AND $tab == 'pending') {
            $users = User::pending();
        } else if ($tab = $request->tab AND $tab == 'active') {
            $users = User::active();
        } else {
            $users = User::where('id', '>=', 1);
        }

        $users = $users->search($request->only(['search']));
        $users = $users->filter($request);
        $count = $users->count();
        !empty($request->order) ? $users->order($request) : $users->latest();
        $limit = !empty($request->limit) ? $request->limit : $this->limit;
        $users = $users->paginate($limit)
                    ->withQueryString();

        $tabFilters = $this->tabFilters($request);

        $roles = $this->roles;

        $plugins = [
            'assets/js/plugins/notifications/bootbox.min.js',
            'assets/js/plugins/ui/moment/moment.min.js',
            'assets/js/plugins/pickers/daterangepicker.js',
            'assets/js/plugins/table/finderSelect/jquery.finderSelect.min.js',
        ];

        return view('user.index', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'users',
            'count',
            'onlyTrashed',
            'tabFilters',
            'roles',
            'plugins'
        ));
    }

    private function tabFilters($request)
    {
        return [
            'all'       => User::search($request->only(['search']))->filter($request)->count(),
            'pending'   => User::pending()->search($request->only(['search']))->filter($request)->count(),
            'active'    => User::active()->search($request->only(['search']))->filter($request)->count(),
            'trash'     => User::onlyTrashed()->search($request->only(['search']))->filter($request)->count()
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect('/admin/users')->with('message', '<strong>Berhasil!</strong> Operator baru telah berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        return view('admin.user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $pageHeader = 'Ubah Operator';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('admin.dashboard') => '<i class="icon-home2 mr-2"></i>Dasbor',
            '#' => 'Pengaturan',
            route('admin.user.index') => 'Operator',
            'Ubah' => TRUE
        ];

        $roles = $this->roles;
        return view('admin.user.edit', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'user',
            'roles',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $oldPicture = $user->picture;
        $validated  = $this->handleRequest($request);

        $user->update($validated);

        if ($oldPicture !== $user->picture) {
            $this->removeImage($oldPicture);
        }

        return redirect('/admin/user')->with('message', '<strong>Berhasil!</strong> Perubahan data Operator telah berhasil disimpan');
    }

    private function handleRequest($request)
    {
        $data = $request->validated();

        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $path  = $image->store('users', 'public');
            $data['picture'] = $path;

            // Create thumbnail
            $extension = $image->getClientOriginalExtension();
            $thumbnail = Str::replace(".{$extension}", "_thumb.{$extension}", $path);
            if (Storage::disk('public')->exists($path)) {
                Image::make(storage_path('app/public/' . $path))->fit(200)->save(storage_path('app/public/' . $thumbnail));
            }
        }

        return $data;
    }

    public function trigger(Request $request)
    {
        $ids = $request->items;
        $count = count($ids);

        $message = 'data Operator telah berhasil diperbarui';
        foreach ($ids as $id)
        {
            $user = User::find($id);
            if ($request->action == 'status')
            {
                if ($request->val == 'pending') {
                    $user->email_verified_at = null;
                } else if ($request->val == 'active') {
                    $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
                }
                $user->save();
            }
            else if ($request->action == 'role')
            {
                $user->role = $request->val;
                $user->save();
            }
            else if ($request->action == 'trash')
            {
                $user->delete();
                $message = 'data Operator telah berhasil dibuang ke Trash';
            }
        }

        $request->session()->flash('message', '<span class="badge badge-pill badge-success">' . $count . '</span> ' . $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $action = route('admin.user.restore', $user->id);
        $user->delete();

        return redirect('/admin/user')->with('trash-message', ['<strong>Berhasil!</strong> Data Operator telah dibuang ke Trash', $action]);
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->back()->with('message', 'Data Operator telah dikembalikan dari Trash');
    }

    public function forceDestroy($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();

        $this->removeImage($user->picture);

        return redirect('/admin/user?tab=trash')->with('message', '<strong>Berhasil!</strong> Data Operator telah berhasil dihapus');
    }

    public function deleteAvatar(Request $request, User $user)
    {
        $this->removeImage($user->picture);
        $user->update(['picture' => null]);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Data Foto telah berhasil dihapus');
    }

    public function setNewPassword(Request $request, User $user)
    {
        $validated = $request->validate([
            'password_current' => 'required|current_password',
            'password'  => 'required|string|min:6|confirmed'
        ]);

        $user->update(['password' =>  Hash::make($validated['password'])]);

        $request->session()->flash('message', '<strong>Berhasil!</strong> Kata Sandi Anda sudah berhasil diperbarui');
    }
}
