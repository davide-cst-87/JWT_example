<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ];
    }
}

//{
//    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3MzcxMzMwMDUsImV4cCI6MTczNzEzNjYwNSwibmJmIjoxNzM3MTMzMDA1LCJqdGkiOiJMMVNRU0VJN3hETDF4MG9IIiwic3ViIjoiNiIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.N_q2LSY6MjYByTYLONwZY3wBb80dIWr7bAOdu23dqJk",
//    "token_type": "bearer",
//    "expires_in": 3600
//}

//{
//    e@hotmail.com
//password
//    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjgwMDAvYXBpL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3MzcxNTI3NDMsImV4cCI6MTczNzE1NjM0MywibmJmIjoxNzM3MTUyNzQzLCJqdGkiOiI3a0ozZ0pESGNqbzRQdWNtIiwic3ViIjoiNyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.Zd_C7sYRoNLWxdJ0ZsdZa5B8dF32CS0h_srTYCKbhcc",
//    "token_type": "bearer",
//    "expires_in": 3600
//}

