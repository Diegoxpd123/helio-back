<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource with pagination, sorting and filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Department::with('parentDepartment', 'subDepartments');

        // Búsqueda global
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('ambassador_name', 'LIKE', "%{$search}%");
            });
        }

        // Filtros por columna
        if ($request->has('filters')) {
            $filters = json_decode($request->filters, true);
            
            foreach ($filters as $column => $values) {
                if (!empty($values)) {
                    if ($column === 'name') {
                        $query->whereIn('name', $values);
                    } elseif ($column === 'parent_department_id') {
                        $query->whereIn('parent_department_id', $values);
                    }
                }
            }
        }

        // Ordenamiento
        $sortField = $request->get('sortField', 'id');
        $sortOrder = $request->get('sortOrder', 'asc');
        
        if ($sortField === 'parent_department_name') {
            $query->join('departments as parent', 'departments.parent_department_id', '=', 'parent.id', 'left')
                  ->select('departments.*', 'parent.name as parent_department_name')
                  ->orderBy('parent.name', $sortOrder);
        } else {
            $query->orderBy($sortField, $sortOrder);
        }

        // Paginación
        $perPage = $request->get('perPage', 10);
        $departments = $query->paginate($perPage);

        // Agregar contador de subdepartamentos
        $departments->getCollection()->transform(function ($department) {
            $department->sub_departments_count = $department->subDepartments->count();
            $department->parent_department_name = $department->parentDepartment?->name;
            return $department;
        });

        // Calcular total de colaboradores
        $totalEmployees = Department::sum('employees_count');

        return response()->json([
            'data' => $departments->items(),
            'current_page' => $departments->currentPage(),
            'last_page' => $departments->lastPage(),
            'per_page' => $departments->perPage(),
            'total' => $departments->total(),
            'total_employees' => $totalEmployees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:45|unique:departments,name',
            'parent_department_id' => 'nullable|exists:departments,id',
            'level' => 'required|integer|min:1',
            'employees_count' => 'required|integer|min:0',
            'ambassador_name' => 'nullable|string|max:255',
        ]);

        $department = Department::create($validated);
        $department->load('parentDepartment', 'subDepartments');
        $department->sub_departments_count = $department->subDepartments->count();
        $department->parent_department_name = $department->parentDepartment?->name;

        return response()->json([
            'message' => 'Departamento creado exitosamente',
            'data' => $department
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResponse
    {
        $department = Department::with('parentDepartment', 'subDepartments')->findOrFail($id);
        $department->sub_departments_count = $department->subDepartments->count();
        $department->parent_department_name = $department->parentDepartment?->name;

        return response()->json([
            'data' => $department
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $department = Department::findOrFail($id);

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:45', Rule::unique('departments')->ignore($department->id)],
            'parent_department_id' => 'sometimes|nullable|exists:departments,id',
            'level' => 'sometimes|required|integer|min:1',
            'employees_count' => 'sometimes|required|integer|min:0',
            'ambassador_name' => 'nullable|string|max:255',
        ]);

        // Evitar referencia circular
        if (isset($validated['parent_department_id']) && $validated['parent_department_id'] == $department->id) {
            return response()->json([
                'message' => 'Un departamento no puede ser su propio superior'
            ], 422);
        }

        $department->update($validated);
        $department->load('parentDepartment', 'subDepartments');
        $department->sub_departments_count = $department->subDepartments->count();
        $department->parent_department_name = $department->parentDepartment?->name;

        return response()->json([
            'message' => 'Departamento actualizado exitosamente',
            'data' => $department
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json([
            'message' => 'Departamento eliminado exitosamente'
        ]);
    }

    /**
     * Get subdepartments of a specific department.
     */
    public function subdepartments(string $id): JsonResponse
    {
        $department = Department::findOrFail($id);
        $subdepartments = $department->subDepartments()->with('parentDepartment', 'subDepartments')->get();

        $subdepartments->transform(function ($dept) {
            $dept->sub_departments_count = $dept->subDepartments->count();
            $dept->parent_department_name = $dept->parentDepartment?->name;
            return $dept;
        });

        return response()->json([
            'data' => $subdepartments
        ]);
    }
}
