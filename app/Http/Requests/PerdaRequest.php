<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
    public function rules()
    {
        return [
            'title'        => 'required|max:767',
            'slug'         => 'required',
            'background'   => 'nullable',
            'institute_id' => 'required',
            'master'       => 'required|file|mimes:pdf,doc,docx|max:2048',
            'attachments'   => 'array',
            'attachments.*.title' => 'required_with:attachments.*.file',
            'attachments.*.file'  => 'required_with:attachments.*.title|file|mimes:pdf, doc, docx|max:2048',
            'requirements'   => 'array',
            'requirements.*.title' => 'required_with:requirements.*.file',
            'requirements.*.file'  => 'required_with:requirements.*.title|file|mimes:pdf, doc, docx|max:2048',
        ];
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
