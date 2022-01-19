<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    private $rules = [
        'name'          => 'required|string|max:255',
        'email'         => 'required|email|unique:users,email',
        'phone'         => 'required|regex:/(0)[0-9]/|not_regex:/[a-z]/|min:11|max:15',
        'date_of_birth' => 'nullable|date',
        'password'      => 'required|same:confirm_password'
    ];

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
        // on update statement
        if ($this->method() == 'PUT') {
            $this->rules['email'] = 'nullable|email|unique:users,email,' . $this->id;
        }
        return $this->rules;
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The Name field is required.',
        ];
    }
}
