<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments for the organization.
     */
    public function index()
    {
        $user = Auth::user();
        $organization = $user->organization;

        $departments = Department::where('organization_id', $user->organization_id)
            ->withCount('users')
            ->orderBy('name')
            ->get();

        return view('hr.departments.index', compact('user', 'organization', 'departments'));
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')->where(function ($query) use ($user) {
                    return $query->where('organization_id', $user->organization_id);
                }),
            ],
        ]);

        Department::create([
            'organization_id' => $user->organization_id,
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('hr.departments.index')
            ->with('success', 'Department created successfully.');
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $user = Auth::user();

        // Ensure department belongs to logged in user's organization
        if ($department->organization_id !== $user->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('departments', 'name')->where(function ($query) use ($user) {
                    return $query->where('organization_id', $user->organization_id);
                })->ignore($department->id),
            ],
        ]);

        $department->update([
            'name' => trim($validated['name']),
        ]);

        return redirect()->route('hr.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        $user = Auth::user();

        if ($department->organization_id !== $user->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete only if no employees are assigned to it
        if ($department->users()->count() > 0) {
            return redirect()->route('hr.departments.index')
                ->with('error', 'Cannot delete department because employees are currently assigned to it.');
        }

        $department->delete();

        return redirect()->route('hr.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
