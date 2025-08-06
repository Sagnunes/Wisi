<?php

declare(strict_types=1);

namespace App\Http\Requests\Shelves;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class UpdateShelvesRequest extends FormRequest
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
        $shelve = $this->route('shelve');

        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('shelves')->ignore($shelve->id)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve ser um texto.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'name.unique' => 'Este nome já está a ser utilizado.',
        ];
    }
}
