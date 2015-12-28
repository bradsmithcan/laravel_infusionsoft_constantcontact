<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateUserRequest extends Request
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
        $user = \Auth::user();
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'. $user->id,
            'password' => 'required|confirmed|min:6',
        ];
    }
}