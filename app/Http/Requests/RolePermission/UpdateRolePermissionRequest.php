<?php

declare(strict_types=1);

namespace App\Http\Requests\RolePermission;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateRolePermissionRequest extends FormRequest
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
            'selectedPermissions' => ['array'],
            'selectedPermissions.*' => ['integer', 'exists:permissions,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'selectedPermissions.array' => 'O campo permissões deve ser um conjunto de valores.',
            'selectedPermissions.*.int' => 'Cada permissão deve ser um valor do tipo número.',
            'selectedPermissions.*.exists' => 'Uma ou mais permissões selecionadas não são válidas.',
        ];
    }
}
