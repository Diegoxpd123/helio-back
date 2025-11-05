<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'name' => 'required|string|max:45|unique:departments,name',
            'parent_department_id' => 'nullable|exists:departments,id',
            'level' => 'required|integer|min:1',
            'employees_count' => 'required|integer|min:0',
            'ambassador_name' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del departamento es obligatorio',
            'name.unique' => 'Ya existe un departamento con este nombre',
            'name.max' => 'El nombre no puede exceder 45 caracteres',
            'parent_department_id.exists' => 'El departamento superior no existe',
            'level.required' => 'El nivel es obligatorio',
            'level.min' => 'El nivel debe ser al menos 1',
            'employees_count.required' => 'El número de colaboradores es obligatorio',
            'employees_count.min' => 'El número de colaboradores no puede ser negativo',
            'ambassador_name.max' => 'El nombre del embajador no puede exceder 255 caracteres',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'nombre',
            'parent_department_id' => 'departamento superior',
            'level' => 'nivel',
            'employees_count' => 'número de colaboradores',
            'ambassador_name' => 'nombre del embajador',
        ];
    }
}

