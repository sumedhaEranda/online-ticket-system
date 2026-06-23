<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check(); // change to true if guests are allowed
    }

    public function rules()
    {
        return [
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['nullable', 'string', 'max:30', 'regex:/^[0-9+\-\s()]{6,30}$/'],
            'problem_description' => 'required|string|min:10|max:5000',
        ];
    }

    public function messages()
    {
        return [
            'problem_description.min' => 'Please provide more details (at least 10 characters).',
        ];
    }
}