<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Requirement;

class RanperdaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'title' => 'judul',
            'institute_id'  => 'perangkat daerah',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(Request $request)
    {
        $rules = [
            'title'         => 'required|max:767',
            'slug'          => 'required|unique:legislations',
            'background'    => 'nullable',
            'institute_id'  => 'required',
        ];

        if ($request->has('post')) {
            $master = Requirement::master(1)->first();
            $rules[$master->term] = 'required|file|mimes:'.$master->format.'|max:2048';

            $requirements = Requirement::requirements(1)->get();
            foreach ($requirements as $requirement) {                
                $rules[$requirement->term] = 'required|file|mimes:'.$requirement->format.'|max:2048';
            }
        }

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = [
                    'required',
                    Rule::unique('legislations')->ignore($this->route('ranperda'))
                ];

                $rules = Arr::except($rules, ['institute_id']);
                break;
        }
        
        return $rules;
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'slug' => Str::slug($this->title),
        ]);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    // public function messages()
    // {
    //     return [
    //         'master.required'   => 'Dokumen Draf Ranperda belum diunggah',
    //         'surat_pengantar.required'   => 'Dokumen Surat Pengantar belum diunggah',
    //         'naskah_akademik.required'   => 'Dokumen Naskah Akademik belum diunggah',
    //         'notulensi_rapat.required'   => 'Dokumen Notulensi Rapat belum diunggah',
    //     ];
    // }
}
