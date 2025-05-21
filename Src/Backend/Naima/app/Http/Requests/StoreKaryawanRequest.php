<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKaryawanRequest extends FormRequest
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
            'nama_lengkap' => 'required|string|max:255',
            'email'        => 'required|email|unique:karyawans,email|unique:users,email',
            'password'     => 'required|min:8|confirmed',
            'role'         => 'required|in:karyawan',
            'no_telp'      => 'nullable|digits_between:9,13',
            'foto'         => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    /**
     * Get custom error messages for validation.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nama_lengkap.required' => 'Nama lengkap tidak boleh kosong.',
            'email.required'        => 'Email tidak boleh kosong.',
            'email.unique'          => 'Email tersebut sudah digunakan.',
            'password.required'     => 'Password tidak boleh kosong.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'role.required'         => 'Role tidak boleh kosong.',
            'role.in'               => 'Role harus berupa karyawan.',
            'no_telp.digits_between' => 'Nomor telepon harus antara 9 hingga 13 digit.',
            'foto.file'             => 'Foto harus berupa file.',
            'foto.mimes'            => 'Foto harus memiliki format jpg, jpeg, atau png.',
            'foto.max'              => 'Ukuran foto maksimal adalah 2MB.',
        ];
    }
}
