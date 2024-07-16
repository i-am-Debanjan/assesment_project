<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //employees menu routes
    Route::prefix('employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::post('/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::get('/delete/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
        
    });
    
    //companies menu routes
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('companies');
        Route::get('/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::post('/store', [CompanyController::class, 'store'])->name('companies.store');
        Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::post('/update/{id}', [CompanyController::class, 'update'])->name('companies.update');
        Route::get('/delete/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
        
    });
});

// Route::get('/rc/{id}', [CompanyController::class, 'restoreCompany']);
// Route::get('/re/{id}', [EmployeeController::class, 'restoreEmp']);
require __DIR__.'/auth.php';
