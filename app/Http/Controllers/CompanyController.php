<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::paginate(10);
        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:companies',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100',
            'website' => 'nullable|url',
        ]);

        try {

            $filePath = null;
            // Attempt to upload the file
            if ($request->hasFile('logo')) {
                // Get the file from the request
                $file = $request->file('logo');

                // Generate a unique name for the file
                $fileName = $request->name . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store the file in the public storage disk
                $filePath = $file->storeAs('public', $fileName);
            }

            // Create and save the Company model
            $company = new Company();
            $company->name = $request->name;
            $company->email = $request->email;

            // Set logo field if file was uploaded
            if ($filePath) {
                $company->logo = $filePath;
            }

            $company->website = $request->website;
            $company->save();

            return redirect()->route('companies')->with('success', 'Company created successfully.');

        } catch (QueryException $e) {
            // Handle database query errors
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save company.']);
        } catch (\Exception $e) {
            // Handle other exceptions
            if ($filePath && Storage::exists($filePath)) {
                Storage::delete($filePath); // Delete the uploaded file if an exception occurred
            }
            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to save company. ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {

            $company = Company::findOrFail($id);
            return view('companies.edit', compact('company'));

        } catch (\Exception $e) {

            return redirect()->to('companies')->with('error', 'Company not found..!');

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        try {
            $company = Company::findOrFail($id);
            $rules = [
                'name' => 'required|string|max:255',
                'email' => 'nullable|email',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg|dimensions:min_width=100,min_height=100',
                'website' => 'nullable|url'
            ];


            $company->name = $request->name;
            //add unique validation rule to name if name changed
            if ($company->isDirty('name')) {
                $rules['name'] .= '|unique:companies';
            }
            // Validate the request
            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator);
            }
            // Update the company's details if changed
            $company->email = $request->email;
            $company->website = $request->website;

            // Attempt to upload the file
            if ($request->hasFile('logo')) {
                // Get the file from the request
                $file = $request->file('logo');

                // Generate a unique name for the file
                $fileName = $request->name . '_' . time() . '.' . $file->getClientOriginalExtension();

                // Store the file in the public storage disk
                $filePath = $file->storeAs('public', $fileName);

                // Delete the previous logo if it exists
                if ($company->logo) {
                    Storage::delete($company->logo);
                }

                // Update the logo path in the company record
                $company->logo = $filePath;
            }

            // Check if any changes were made
            if ($company->isDirty()) {
                $company->save();
                return redirect()->to('companies')->with('success', 'Company updated successfully.');
            } else {
                return back()->with('error', 'No changes were made.');
            }
        } catch (QueryException $e) {
            // Handle database query errors
            return redirect()->back()->with(['error' => 'Failed to update company.']);
        } catch (\Exception $e) {
            return redirect()->to('companies')->with('error', 'Company not found..!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            return redirect()->route('companies')->with('success', 'Company deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('companies')->with('error', 'Company not found or already deleted.');
        }
    }
    public function restoreCompany($companyId)
    {
        // Find the soft-deleted company by its ID
        $company = Company::withTrashed()->find($companyId);

        if (!$company) {
            // Handle case where company with given ID doesn't exist or isn't soft-deleted
            return redirect()->back()->with('error', 'Company not found or not soft-deleted.');
        }

        // Restore the company and associated employees (if any were soft-deleted)
        $company->restore();

        return redirect()->route('companies')->with('success', 'Company restored successfully.');
    }
}
