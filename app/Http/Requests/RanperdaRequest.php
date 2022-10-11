<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Models\Requirement;
use App\Models\Document;

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
            'slug'  => 'judul',
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
            'slug'          => 'unique:legislations',
            'background'    => 'nullable',
            'institute_id'  => 'required',
        ];

        $requirements = Requirement::mandatory(1)->get();

        switch ($this->method()) {
            case 'POST':
                if ($request->has('post')) {
                    foreach ($requirements as $requirement) {                
                        $rules[$requirement->term] = 'required|file|mimes:'.$requirement->format.'|max:2048';
                    }
                }
                break;
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = [
                    'required',
                    Rule::unique('legislations')->ignore($this->route('ranperda'))
                ];

                if ($request->has('post') OR $request->has('revise')) {

                    // Check document requirements
                    foreach ($requirements as $requirement) {  
                        $document = Document::where('legislation_id', $this->route('ranperda')->id)
                                        ->where('requirement_id', $requirement->id);
                        if ($document->doesntExist()) {
                            $rules[$requirement->term] = 'required|file|mimes:'.$requirement->format.'|max:2048';
                        }
                    }
                }

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
    
}
