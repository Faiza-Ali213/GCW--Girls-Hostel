<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by role
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get statistics
        $totalUsers   = User::count();
        $activeUsers  = User::active()->count();
        $inactiveUsers = User::inactive()->count();
        $adminUsers   = User::admins()->count();
        $clerkUsers   = User::clerks()->count();

        // Fix: Use the correct view path
        return view('Pages.Admin.user-management', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'adminUsers',
            'clerkUsers'
        ));
    }

    /**
     * Show form to create new user.
     */
    public function create()
    {
        return view('Component.Admin.add-user-modal');
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:admin,clerk',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:500',
            'status'   => 'required|in:active,inactive',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Prepare user data
            $userData = [
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => $request->role,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'status'   => $request->status,
                'email_verified_at' => now(), // Auto-verify email
            ];

            // Handle profile photo upload if provided
            if ($request->hasFile('profile_photo')) {
                $photo = $request->file('profile_photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('profile_photos', $filename, 'public');
                $userData['profile_photo'] = $path;
            }

            // Create user
            $user = User::create($userData);

            // Send notification - Fixed: Use fully qualified namespace
            if (class_exists('App\Http\Controllers\NotificationController')) {
                \App\Http\Controllers\NotificationController::notifyUserCreated($user);
            }

            return redirect()->route('users.index')
                ->with('success', 'User "' . $user->name . '" created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create user: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show a specific user.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('Component.Admin.view-user-modal', compact('user'));
    }

    /**
     * Show form to edit user.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('Component.Admin.edit-user-modal', compact('user'));
    }

    /**
     * Update a user.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'role'   => 'required|in:admin,clerk',
            'phone'  => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => 'required|in:active,inactive',
        ]);

        // Handle password update only if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        // Store old values for notification comparison
        $oldStatus = $user->status;
        $oldRole   = $user->role;

        $user->update($validated);

        // Send notification for status change
        if ($user->wasChanged('status') && class_exists('App\Http\Controllers\NotificationController')) {
            \App\Http\Controllers\NotificationController::notifyUserStatusChanged($user);
        }

        // Send notification for role change
        if ($user->wasChanged('role') && class_exists('App\Http\Controllers\NotificationController')) {
            \App\Http\Controllers\NotificationController::notifyUserRoleChanged($user);
        }

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully!');
    }

    /**
     * Delete a user.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent deleting self
            if ($user->id === auth()->id()) {
                return redirect()->route('users.index')
                                 ->with('error', 'You cannot delete your own account!');
            }

            // Prevent deleting admin users (extra safety)
            if ($user->isAdmin()) {
                return redirect()->route('users.index')
                                 ->with('error', 'Administrator accounts cannot be deleted!');
            }

            $user->delete();

            return redirect()->route('users.index')
                             ->with('success', 'User "' . $user->name . '" deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('users.index')
                             ->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
    }

    /**
     * Update user status.
     */
    public function updateStatus(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $request->validate([
                'status' => 'required|in:active,inactive'
            ]);

            $user->update(['status' => $request->status]);

            // Send notification for status change
            if (class_exists('App\Http\Controllers\NotificationController')) {
                \App\Http\Controllers\NotificationController::notifyUserStatusChanged($user);
            }

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User status updated successfully!',
                    'status'  => $user->status
                ]);
            }

            return redirect()->route('users.index')
                             ->with('success', 'User status updated successfully!');

        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('users.index')
                             ->with('error', 'Failed to update status: ' . $e->getMessage());
        }
    }

    /**
     * Export users to CSV (optional).
     */
    public function export()
    {
        $users = User::all();
        // Implement CSV export logic
        return redirect()->back()->with('success', 'Export started!');
    }
}