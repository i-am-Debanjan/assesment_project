<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Employee;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Total registered companies
        $totalCompanies = Company::count();

        // Employees added this month
        $employeesAddedThisMonth = Employee::whereMonth('created_at', Carbon::now()->month)->count();

        // Total employees added overall
        $totalEmployees = Employee::count();

        return view('dashboard', compact('totalCompanies', 'employeesAddedThisMonth', 'totalEmployees'));
    }
}
