<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        return [
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
    }
}
