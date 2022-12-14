<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class InstituteRequest extends FormRequest
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
        $rules = [
            'name'      => 'required|max:255',
            'slug'      => 'required|unique:institutes',
            'abbrev'    => 'nullable|unique:institutes',
            'category'  => 'required',
            'corrector_id' => 'required',
            'users'     => 'nullable|array',
            'users.*'   => 'sometimes|unique:institute_user,user_id',
            'code'      => 'nullable',
            'desc'      => 'nullable',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['slug'] = [
                    'required',
                    Rule::unique('institutes')->ignore($this->route('institute'))
                ];

                $rules['abbrev'] = [
                    'nullable',
                    Rule::unique('institutes')->ignore($this->route('institute'))
                ];

                $ignored_users = $this->route('institute')->users->pluck('id');
                $rules['users.*'] = [
                    'sometimes',
                    Rule::unique('institute_user', 'user_id')->where(function ($query) use ($ignored_users) {
                        $query->whereNotIn('user_id', $ignored_users);
                        return $query;
                    })
                ];

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
            'slug' => Str::slug($this->name),
        ]);
    }
}
