<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\ApiRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends ApiRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:users,name|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|numeric|min:15',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'cv' => 'nullable|mimes:pdf',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Nama mohon untuk diisi',
            'name.unique' => 'Nama sudah digunakan',
            'email.required' => 'Email mohon untuk diisi',
            'email.email' => 'Mohon email berupa Gmail',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password mohon untuk diisi',
            'password.min' => 'Password minimal 8 karakter',
            'phone_number.required' => 'Nomer mohon untuk diisi',
            'phone_number.numeric' => 'Mohon nomer berupa angka',
            'phone_number.min' => 'Nomer minimal 15 karakter',
            'address.required' => 'Alamat mohon untuk diisi',
            'cv' => 'CV harus berupa PDF'
        ];
    }
}
