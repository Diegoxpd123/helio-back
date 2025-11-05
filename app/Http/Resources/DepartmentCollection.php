<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DepartmentCollection extends ResourceCollection
{
    /**
     * The "data" wrapper that should be applied.
     *
     * @var string|null
     */
    public static $wrap = 'data';

    /**
     * Total employees across all departments.
     *
     * @var int
     */
    protected $totalEmployees;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  int  $totalEmployees
     * @return void
     */
    public function __construct($resource, int $totalEmployees = 0)
    {
        parent::__construct($resource);
        $this->totalEmployees = $totalEmployees;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'total_employees' => $this->totalEmployees,
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

    /**
     * Customize the pagination information for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array $paginated
     * @param  array $default
     * @return array
     */
    public function paginationInformation($request, $paginated, $default): array
    {
        return [
            'current_page' => $paginated['current_page'] ?? null,
            'last_page' => $paginated['last_page'] ?? null,
            'per_page' => $paginated['per_page'] ?? null,
            'total' => $paginated['total'] ?? null,
        ];
    }
}

