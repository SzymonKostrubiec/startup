<?php

namespace App\Http\Requests;

use App\Dtos\StoreOrUpdateUserDto;
use Illuminate\Foundation\Http\FormRequest;

final class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'min:9', 'max:15'],
            'emails' => ['required', 'array'],
            'emails.*' => ['required', 'email', 'max:255', 'unique:user_emails,email'],
        ];
    }

    public function getDto(): StoreOrUpdateUserDto
    {
        return new StoreOrUpdateUserDto(
            $this->input('name'),
            $this->input('last_name'),
            $this->input('phone'),
            $this->input('emails')
        );
    }
}
