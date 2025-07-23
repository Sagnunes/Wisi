<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateUserRoleRequest extends FormRequest
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
            'selectedRoles' => ['array', 'exists:roles,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'selectedRoles.integer' => 'O estado deve ser um número inteiro.',
            'selectedRoles.exists' => 'O estado selecionado não existe na base de dados.',

            'user_id.required' => 'O utilizador é obrigatório.',
            'user_id.integer' => 'O ID do utilizador deve ser um número inteiro.',
            'user_id.exists' => 'O utilizador selecionado não existe na base de dados.',
        ];
    }
}
