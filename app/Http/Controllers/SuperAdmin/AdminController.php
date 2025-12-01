<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index(Request $request)
    {
        $query = User::role(['superadmin', 'admin'])
            ->with('roles')
            ->orderBy('name');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $admins = $query->paginate(10);

        return view('superadmin.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create()
    {
        $roles = Role::whereIn('name', ['superadmin', 'admin'])->get();
        return view('superadmin.admins.create', compact('roles'));
    }

    /**
     * Store a newly created admin.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:superadmin,admin',
            'status' => 'required|in:active,inactive',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => $validated['status'],
            'created_by' => auth()->id(),
        ]);

        $user->assignRole($validated['role']);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin created successfully!');
    }

    /**
     * Show the form for editing an admin.
     */
    public function edit(User $admin)
    {
        $roles = Role::whereIn('name', ['superadmin', 'admin'])->get();
        return view('superadmin.admins.edit', compact('admin', 'roles'));
    }

    /**
     * Update the specified admin.
     */
    public function update(Request $request, User $admin)
    {
        // Prevent changing own role
        if ($admin->id === auth()->id() && $request->role !== $admin->getRoleNames()->first()) {
            return back()->withErrors(['role' => 'You cannot change your own role.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($admin->id)],
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:superadmin,admin',
            'status' => 'required|in:active,inactive',
        ]);

        $admin->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'status' => $validated['status'],
        ]);

        if ($request->filled('password')) {
            $admin->update(['password' => Hash::make($validated['password'])]);
        }

        $admin->syncRoles([$validated['role']]);

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin updated successfully!');
    }

    /**
     * Remove the specified admin.
     */
    public function destroy(User $admin)
    {
        // Prevent self-deletion
        if ($admin->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete yourself.']);
        }

        $admin->delete();

        return redirect()->route('superadmin.admins.index')
            ->with('success', 'Admin deleted successfully!');
    }

    /**
     * Toggle admin status.
     */
    public function toggleStatus(User $admin)
    {
        $admin->update([
            'status' => $admin->status === 'active' ? 'inactive' : 'active',
        ]);

        return back()->with('success', 'Admin status updated successfully!');
    }
}
