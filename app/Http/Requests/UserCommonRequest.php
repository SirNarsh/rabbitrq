<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCommonRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'min:2'],
            'email' => ['email'],
            'password' => ['string', 'min:8']
        ];
    }
}
