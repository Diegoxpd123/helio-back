<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;

Route::middleware('api')->group(function () {
    // Rutas para departamentos
    Route::apiResource('departments', DepartmentController::class);
    
    // Ruta adicional para obtener subdepartamentos (usando route model binding)
    Route::get('departments/{department}/subdepartments', [DepartmentController::class, 'subdepartments']);
});

