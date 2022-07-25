<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUploadRequest extends FormRequest
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
            'amount' => ['required', 'numeric'],
            'reference' => ['required', 'string:255'],
            'paid_at' => ['required', 'date'],
            'filename' => ['required', 'file', 'mimes:pdf,jpg,png', 'max:2000'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'amount.numeric' => 'Amount entered must be numeric',
            'reference.required' => 'Reference Number is required',
            'reference.string' => 'Reference Number must be a string',
            'filename.mimes' => 'Only PDF, JPG, PNG is supported',
            'filename.max' => 'Maximum file size is 2MB',
        ];
    }
}
