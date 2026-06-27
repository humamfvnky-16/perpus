<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBorrowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('borrow.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'member_id' => ['required','exists:members,id'],
            'book_id'   => ['required','exists:books,id'],
            'days'      => ['nullable','integer','min:1','max:30'],
            'notes'     => ['nullable','string','max:500'],
        ];
    }
}
