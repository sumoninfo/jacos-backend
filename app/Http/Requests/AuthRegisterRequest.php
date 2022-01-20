<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
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
            'name'          => 'required|string',
            'email'         => 'required|email|unique:users,email',
            'phone'         => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:11|max:15',
            'password'      => 'required|same:confirm_password',
            'date_of_birth' => 'nullable|date',
            'gender'        => 'nullable',
            'address'       => 'nullable'
        ];
    }
}
