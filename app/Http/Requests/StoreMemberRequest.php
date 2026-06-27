<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('member.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'name'        => ['required','string','max:255'],
            'email'       => ['required','email','unique:users,email'],
            'password'    => ['required','string','min:8','confirmed'],
            'nis_nip'     => ['nullable','string','max:30'],
            'type'        => ['required','in:student,teacher,staff,public'],
            'class'       => ['nullable','string','max:50'],
            'major'       => ['nullable','string','max:100'],
            'address'     => ['nullable','string','max:500'],
            'birth_date'  => ['nullable','date'],
            'gender'      => ['nullable','in:M,F'],
            'expires_at'  => ['nullable','date','after:today'],
        ];
    }
}
