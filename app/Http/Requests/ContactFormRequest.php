<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phoneNumber' => ['required', 'string', 'min:10', 'max:20'],
            'subject' => ['required', 'string', 'min:5', 'max:255'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.min' => 'Your name must be at least 3 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'phoneNumber.required' => 'Please enter your phone number.',
            'phoneNumber.min' => 'Your phone number must be at least 10 characters.',
            'subject.required' => 'Please enter a subject.',
            'subject.min' => 'The subject must be at least 5 characters.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Your message must be at least 10 characters.',
            'message.max' => 'Your message must not exceed 5000 characters.',
        ];
    }
}
