<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_department_id' => $this->parent_department_id,
            'parent_department_name' => $this->whenLoaded('parentDepartment', 
                fn() => $this->parentDepartment?->name
            ),
            'level' => $this->level,
            'employees_count' => $this->employees_count,
            'ambassador_name' => $this->ambassador_name,
            'sub_departments_count' => $this->whenLoaded('subDepartments',
                fn() => $this->subDepartments->count(),
                0
            ),
            'sub_departments' => DepartmentResource::collection($this->whenLoaded('subDepartments')),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @return array<string, mixed>
     */
    public function with(Request $request): array
    {
        return [
            'success' => true,
        ];
    }
}

