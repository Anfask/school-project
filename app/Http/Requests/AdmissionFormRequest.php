<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdmissionFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'surname' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'father_name' => 'required|string|max:100',
            'mother_name' => 'required|string|max:100',
            'guardian_name' => 'nullable|string|max:100',
            'local_address' => 'required|string|max:255',
            'mobile_1' => 'required|regex:/^[0-9]{10}$/',
            'mobile_2' => 'nullable|regex:/^[0-9]{10}$/',
            'email' => 'required|email|max:255',
            'religion' => 'nullable|string|max:50',
            'caste' => 'nullable|string|max:50',
            'sub_caste' => 'nullable|string|max:50',
            'nationality' => 'required|string|max:50',
            'place_of_birth' => 'required|string|max:100',
            'date_of_birth' => 'required|date|before:today',
            'last_school_name' => 'required|string|max:100',
            'last_school_address' => 'required|string|max:255',
            'studying_std' => 'required|string|max:50',
            'since_date' => 'required|date',
            'medium_of_instruction' => 'required|string|max:50',
            'occupation' => 'nullable|string|max:100',
            'desired_class' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',
            'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'passport_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'family_photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'g-recaptcha-response' => 'required|captcha',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'The :attribute field is required.',
            'email' => 'Please enter a valid email address.',
            'mobile_1.regex' => 'Mobile number must be 10 digits.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
            'birth_certificate.required' => 'Birth certificate document is required.',
            'passport_photo.required' => 'Passport size photo is required.',
            'family_photo.required' => 'Family photo is required.',
            'g-recaptcha-response.required' => 'Please verify reCAPTCHA.',
        ];
    }
}
