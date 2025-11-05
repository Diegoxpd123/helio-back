<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;

Route::middleware('api')->group(function () {
    // Rutas para departamentos
    Route::apiResource('departments', DepartmentController::class);
    
    // Ruta adicional para obtener subdepartamentos
    Route::get('departments/{id}/subdepartments', [DepartmentController::class, 'subdepartments']);
});

