<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:tbl_user',
            'username' => 'required|string|max:50',
            'password' => 'required',
            'hp' => 'required|string|max:14',
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'tanggal_lahir' => 'required|date|date_format:Y-m-d',
            'tempat_lahir' => 'required|string|max:50',
            'tanggal_nikah' => 'date|date_format:Y-m-d',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'username.required' => 'Username is required!',
            'password.required' => 'Password is required!'
        ];
    }
}
