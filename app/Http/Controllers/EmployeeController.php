<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display the employee directory listing all users in the organization.
     */
    public function index(Request $request)
    {
        $currentUser = Auth::user();
        $organization = $currentUser->organization;

        $search = $request->input('search');
        $departmentId = $request->input('department_id');
        $role = $request->input('role');
        $status = $request->input('status');

        $query = User::where('organization_id', $currentUser->organization_id)
            ->with('departmentRecord');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (!empty($departmentId)) {
            $query->where('department_id', $departmentId);
        }

        if (!empty($role)) {
            $query->where('role', $role);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $employees = $query->orderBy('name')->paginate(15)->withQueryString();

        $departments = Department::where('organization_id', $currentUser->organization_id)
            ->orderBy('name')
            ->get();

        $roles = User::where('organization_id', $currentUser->organization_id)
            ->select('role')
            ->distinct()
            ->pluck('role');

        return view('hr.employees.index', compact(
            'currentUser',
            'organization',
            'employees',
            'departments',
            'roles',
            'search',
            'departmentId',
            'role',
            'status'
        ));
    }

    /**
     * Show employee profile edit form.
     */
    public function edit(User $employee)
    {
        $currentUser = Auth::user();

        if ($employee->organization_id !== $currentUser->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $departments = Department::where('organization_id', $currentUser->organization_id)
            ->orderBy('name')
            ->get();

        return view('hr.employees.edit', compact('currentUser', 'employee', 'departments'));
    }

    /**
     * Update employee profile (position, department assignment, status).
     */
    public function update(Request $request, User $employee)
    {
        $currentUser = Auth::user();

        if ($employee->organization_id !== $currentUser->organization_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'department_id' => [
                'nullable',
                Rule::exists('departments', 'id')->where(function ($query) use ($currentUser) {
                    return $query->where('organization_id', $currentUser->organization_id);
                }),
            ],
            'position' => ['nullable', 'string', 'max:255'],
            'date_joined' => ['nullable', 'date'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ]);

        // Keep legacy department string synced if department_id is set
        $departmentName = null;
        if (!empty($validated['department_id'])) {
            $dept = Department::find($validated['department_id']);
            $departmentName = $dept?->name;
        }

        $employee->update([
            'department_id' => $validated['department_id'] ?? null,
            'department' => $departmentName ?? $employee->department,
            'position' => $validated['position'] ?? null,
            'date_joined' => $validated['date_joined'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('hr.employees.index')
            ->with('success', "Profile for {$employee->name} updated successfully.");
    }
}
