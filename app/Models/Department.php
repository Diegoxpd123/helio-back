<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    protected $fillable = [
        'name',
        'parent_department_id',
        'level',
        'employees_count',
        'ambassador_name',
    ];

    protected $casts = [
        'level' => 'integer',
        'employees_count' => 'integer',
    ];

    // Relación con el departamento superior
    public function parentDepartment(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
    }

    // Relación con subdepartamentos
    public function subDepartments(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_department_id');
    }

    // Accessor para contar subdepartamentos
    public function getSubDepartmentsCountAttribute(): int
    {
        return $this->subDepartments()->count();
    }
}
