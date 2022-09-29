<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class PerdaRequest extends FormRequest
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
            'master'        => [
                                Rule::requiredIf($request->has('post')),
                                'file',
                                'mimes:pdf,doc,docx',
                                'max:2048',
                               ],
            'attachments'   => 'nullable|array',
            'attachments.*.title' => [Rule::requiredIf($request->has('post')), 'required_with:attachments.*.file'],
            'attachments.*.file'  => [
                                        Rule::requiredIf($request->has('post')),
                                        'required_with:attachments.*.title',
                                        'file',
                                        'mimes:pdf, doc, docx',
                                        'max:2048',
                                     ],
            'surat_pengantar' => [
                                    Rule::requiredIf($request->has('post')),
                                    'file',
                                    'mimes:pdf, doc, docx',
                                    'max:2048',
                                 ],
            'naskah_akademik' => [
                                    Rule::requiredIf($request->has('post')),
                                    'file',
                                    'mimes:pdf, doc, docx',
                                    'max:2048',
                                 ],
            'notulesi_rapat'  => [
                                    Rule::requiredIf($request->has('post')),
                                    'file',
                                    'mimes:pdf, doc, docx',
                                    'max:2048',
                                 ],
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = [
                    'required',
                    Rule::unique('legislations')->ignore($this->route('perda'))
                ];

                // $rules = Arr::except($rules, ['password', 'institute_id', 'master', 'attachments', 'requirements']);
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
}
