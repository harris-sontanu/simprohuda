<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;

class UserRequest extends FormRequest
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
            'name'      => 'required|string',
            'username'  => 'required|string|unique:users|min:6',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'role'      => 'required',
            'phone'     => 'nullable',
            'picture'   => 'nullable|image|max:2048',
            'www'       => 'nullable|url',
            'bio'       => 'nullable',
            'facebook'  => 'nullable|url',
            'twitter'   => 'nullable|url',
            'instagram' => 'nullable|url',
            'tiktok'    => 'nullable|url',
            'youtube'   => 'nullable|url',
        ];

        switch ($this->method()) {
            case 'PUT':
            case 'PATCH':
                $rules['email'] = [
                    'required',
                    'email',
                    Rule::unique('users', 'email')->ignore($this->route('user'))
                ];

                $rules['username'] = [
                    'required',
                    'string',
                    'min:6',
                    Rule::unique('users', 'username')->ignore($this->route('user'))
                ];

                $rules = Arr::except($rules, ['password']);
                break;
        }

        return $rules;
    }
}
