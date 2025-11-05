<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource with pagination, sorting and filtering.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = Department::with(['parentDepartment', 'subDepartments']);

        // Apply search filter
        $this->applySearch($query, $request);

        // Apply column filters
        $this->applyFilters($query, $request);

        // Apply sorting
        $this->applySorting($query, $request);

        // Paginate results
        $perPage = $request->integer('perPage', 10);
        $departments = $query->paginate($perPage);

        // Calculate total employees
        $totalEmployees = Department::sum('employees_count');

        return DepartmentResource::collection($departments)
            ->additional([
                'total_employees' => $totalEmployees,
            ]);
    }

    /**
     * Apply search filter to query.
     */
    protected function applySearch($query, Request $request): void
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('ambassador_name', 'LIKE', "%{$search}%");
            });
        }
    }

    /**
     * Apply column filters to query.
     */
    protected function applyFilters($query, Request $request): void
    {
        if ($request->filled('filters')) {
            $filters = is_string($request->filters)
                ? json_decode($request->filters, true)
                : $request->filters;

            foreach ($filters as $column => $values) {
                if (!empty($values) && is_array($values)) {
                    match ($column) {
                        'name' => $query->whereIn('name', $values),
                        'parent_department_id' => $query->whereIn('parent_department_id', $values),
                        default => null,
                    };
                }
            }
        }
    }

    /**
     * Apply sorting to query.
     */
    protected function applySorting($query, Request $request): void
    {
        $sortField = $request->get('sortField', 'id');
        $sortOrder = $request->get('sortOrder', 'asc');

        if ($sortField === 'parent_department_name') {
            $query->leftJoin('departments as parent', 'departments.parent_department_id', '=', 'parent.id')
                  ->select('departments.*')
                  ->orderBy('parent.name', $sortOrder);
        } else {
            $query->orderBy($sortField, $sortOrder);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepartmentRequest $request): JsonResponse
    {
        $department = Department::create($request->validated());
        $department->load(['parentDepartment', 'subDepartments']);

        return (new DepartmentResource($department))
            ->additional([
                'message' => 'Departamento creado exitosamente',
            ])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department): DepartmentResource
    {
        $department->load(['parentDepartment', 'subDepartments']);

        return new DepartmentResource($department);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepartmentRequest $request, Department $department): DepartmentResource
    {
        $department->update($request->validated());
        $department->load(['parentDepartment', 'subDepartments']);

        return (new DepartmentResource($department))
            ->additional([
                'message' => 'Departamento actualizado exitosamente',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department): JsonResponse
    {
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Departamento eliminado exitosamente'
        ], 200);
    }

    /**
     * Get subdepartments of a specific department.
     */
    public function subdepartments(Department $department): AnonymousResourceCollection
    {
        $subdepartments = $department->subDepartments()
            ->with(['parentDepartment', 'subDepartments'])
            ->get();

        return DepartmentResource::collection($subdepartments);
    }
}
