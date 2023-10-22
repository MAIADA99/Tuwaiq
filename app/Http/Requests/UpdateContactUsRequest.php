<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'address_ar'=>'required|string',
            'address_en'=>'required|string',
            'phone_1' => 'string',
            'phone_2' => 'string',
            'phone_3' => 'string',
            'email' =>'required|email',
        ];
    }
}
