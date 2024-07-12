<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonationRequest extends FormRequest
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
            'title' => 'required|max:255',
            'picturePath' => 'required|image',
            'description' => 'required',
            'deadline' => 'required',
            'news' => 'required',
            'donationAmount' => 'required|integer',
            'donationNeed' => 'required|integer',
            'types' => ''
        ];
    }
}
