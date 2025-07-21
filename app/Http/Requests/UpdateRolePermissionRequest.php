<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRolePermissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'permissions' => ['array'],
            'permissions.*' => ['string', 'exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'permissions.array' => 'O campo permissões deve ser um conjunto de valores (array).',
            'permissions.*.string' => 'Cada permissão deve ser um valor do tipo texto (UUID).',
            'permissions.*.exists' => 'Uma ou mais permissões selecionadas não são válidas.',
        ];
    }
}
