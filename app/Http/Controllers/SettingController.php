<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function app()
    {
        $pageHeader = 'Pengaturan Aplikasi';
        $pageTitle = $pageHeader . $this->pageTitle;
        $breadCrumbs = [
            route('dashboard') => '<i class="ph-house me-2"></i>Dasbor',
            route('setting.app') => 'Pengaturan',
            'Aplikasi' => TRUE
        ];

        $settings = Setting::pluck('value', 'key');
        
        return view('setting.app', compact(
            'pageTitle',
            'pageHeader',
            'breadCrumbs',
            'settings',
        ));
    }

    public function update(Request $request)
    {   
        $rules = [];
        $settings = Setting::pluck('value', 'key');

        foreach ($settings as $key => $value) {
            $rules[$key] = 'required';
            if ($key == 'appLogo') {
                $rules[$key] = 'nullable|image|max:2048';
            }
        }

        $validated = $request->validate($rules);
        foreach ($validated as $key => $value) {
            Setting::where('key', $key)
                    ->update(['value' => $value]);
        }

        if ($request->hasFile('appLogo')) {
            $path = $request->file('appLogo')->store('images', 'public');

            Setting::where('key', 'appLogo')
                    ->update(['value' => $path]);
        }

        return redirect('/setting')->with('message', '<strong>Berhasil!</strong> Data Pengaturan Aplikasi telah berhasil diperbarui');
    }
}
