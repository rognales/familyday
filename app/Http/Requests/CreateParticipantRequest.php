<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CreateParticipantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return config('familyday.registration') || Auth::check();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => Str::title($this->name),
            'staff_id' => Str::upper($this->staff_id),
            'email' => Str::lower($this->email),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'min:5'],
            'staff_id' => ['required', 'unique:participants,staff_id,NULL,id,deleted_at,NULL'],
            'email' => ['required', 'email'],
            'is_vege' => ['required', 'boolean'],
            'dependant_relationship' => ['nullable', 'array', 'max:6'],
            'dependant_relationship.*' => ['nullable', 'required_with:dependant_name.*'],
            'dependant_age.*' => ['nullable', 'required_with:dependant_name.*', 'numeric'],
            'dependant_name.*' => ['nullable', 'required_with:dependant_name.*', 'string'],
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
            'staff_id.unique' => 'Staff Id is already registered.',
            'staff_id.exists' => "You're not member of TM HQ",
            'is_vege.required' => 'Kindly select meal option',
            'dependant_age.*.numeric' => 'Please enter number only for age',
            'dependant_age.*.required_with' => 'Please specify age for Dependant #:position',
            'dependant_relationship.*.required_with' => 'Please specify relationship for Dependant #:position',
            'dependant_relationship.max' => 'You can only register up to 6 peoples (excluding yourself)',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $this->redirect = route('registration_home') . '#registration';
        $validator->sometimes('staff_id', ['exists:App\Staff,staff_id'], function () {
            return Auth::check() ? false : true;
        });
    }
}
