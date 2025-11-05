<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
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
        $departmentId = $this->route('department');

        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:45',
                Rule::unique('departments', 'name')->ignore($departmentId)
            ],
            'parent_department_id' => [
                'sometimes',
                'nullable',
                'exists:departments,id',
                Rule::notIn([$departmentId]), // Evitar auto-referencia
            ],
            'level' => 'sometimes|required|integer|min:1',
            'employees_count' => 'sometimes|required|integer|min:0',
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
            'parent_department_id.not_in' => 'Un departamento no puede ser su propio superior',
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

