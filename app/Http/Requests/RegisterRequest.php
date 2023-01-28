<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'name' => 'string',
            'email' => 'email',
            'phone' => 'required',
            'street' => 'string',
            'city' => 'string',
            'zipcode' => 'numeric',
            'country' => 'string',
            'state' => 'string',
            'password' => ['min:6']
        ];
    }
}
