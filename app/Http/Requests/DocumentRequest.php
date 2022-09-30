<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class DocumentRequest extends FormRequest
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
            'legislation_id' => 'required',
            'type'      => 'required',
            'order'     => 'required|numeric',
            'title'     => 'required',
            'master'    => [
                            Rule::requiredIf($request->title === 'Draf Ranperda'),
                            'file',
                            'mimes:pdf,doc,docx',
                            'max:2048'
                           ],
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['master'] = [
                    ($request->has('input') AND $request->input === 'master') ? 'required' : 'nullable',
                    'file',
                    'mimes:pdf,doc,docx',
                    'max:2048'
                ];

                $rules = Arr::except($rules, ['legislation_id', 'type', 'order', 'title']);
                break;
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'master.required'   => 'Dokumen Draf Ranperda belum diunggah',
        ];
    }
}
