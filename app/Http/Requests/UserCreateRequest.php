<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends UserCommonRequest
{

     /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $roles = parent::rules();
        $roles['name'][] = 'required';
        $roles['email'][] = 'required';
        $roles['password'][] = 'required';

        return $roles;
    }
}
