<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Employee;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with('company')->paginate(10);

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        return view('employees.create', compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:employees,email,' . $request->id . ',id,company_id,' . $request->company_id,
            'phone' => 'nullable|digits:10',
            'company_id' => 'required',
        ]);

        try {
            // Create and save the Company model
            $employee = new Employee();
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->save();
            return redirect()->route('employees')->with('success', 'Employee created successfully.');

        } catch (QueryException $e) {
            // Handle database query exception
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save employee. Database error.']);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save employee. ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $companies = Company::all();
            $employee = Employee::findOrFail($id);
            return view('employees.edit', compact('employee', 'companies'));

        } catch (\Exception $e) {

            return redirect()->to('employees')->with('error', 'Employee not found..!');

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:employees,email,' . $request->id . ',id,company_id,' . $request->company_id,
            'phone' => 'nullable|digits:10',
            'company_id' => 'required',
        ]);

        try {
            // Create and save the Company model
            $employee = Employee::findOrFail($id);
            $employee->first_name = $request->first_name;
            $employee->last_name = $request->last_name;
            $employee->company_id = $request->company_id;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            // Check if any changes were made
            if ($employee->isDirty()) {
                $employee->save();
                return redirect()->to('employees')->with('success', 'Employee updated successfully.');
            } else {
                return back()->with('error', 'No changes were made.');
            }
        } catch (\Exception $e) {
            return redirect()->to('employees')->with('error', 'Employee not found..!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return redirect()->route('employees')->with('success', 'Employee deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('employees')->with('error', 'Employee not found or already deleted.');
        }
    }
    public function restoreEmp($employeeId)
    {
        // Find the soft-deleted company by its ID
        $employee = Employee::withTrashed()->find($employeeId);

        if (!$employee) {
            // Handle case where company with given ID doesn't exist or isn't soft-deleted
            return redirect()->back()->with('error', 'Employee not found or not soft-deleted.');
        }

        // Restore  employee (if any were soft-deleted)
        $employee->restore();

        return redirect()->route('companies')->with('success', 'Employee restored successfully.');
    }
}
