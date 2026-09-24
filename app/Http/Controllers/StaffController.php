<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /**
     * Display a listing of staff.
     */
    public function index(Request $request)
    {
        $query = Staff::query();

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $staff = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $totalStaff = Staff::count();
        $activeStaff = Staff::active()->count();
        $inactiveStaff = Staff::inactive()->count();

        return view('Pages.Admin.staff_records', compact('staff', 'totalStaff', 'activeStaff', 'inactiveStaff'));
    }

    /**
     * Show form to create new staff.
     */
    public function create()
    {
        return view('Component.Admin.add_staff');
    }

    /**
     * Store a new staff member.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'cnic' => 'nullable|string|max:15',              // ✅ ADDED
            'duty_shift' => 'required|string|max:255',
            'email' => 'nullable|email|max:255|unique:staff',
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'status' => 'nullable|in:active,inactive',
            'remarks' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            $path = $request->file('profile_picture')->store('staff_profiles', 'public');
            $validated['profile_picture'] = $path;
        }

        // Set default status if not provided
        if (!isset($validated['status'])) {
            $validated['status'] = 'active';
        }

        Staff::create($validated);

        return redirect()->route('staff_records')
                         ->with('success', 'Staff member added successfully!');
    }

    /**
     * Show a specific staff member.
     */
    public function show($id)
    {
        $staff = Staff::findOrFail($id);
        return view('Component.Admin.view_staff', compact('staff'));
    }

    /**
     * Show form to edit staff.
     */
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        return view('Component.Admin.edit_staff', compact('staff'));
    }

    /**
     * Update a staff member.
     */
    public function update(Request $request, $id)
    {
        $staff = Staff::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'role' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'cnic' => 'nullable|string|max:15',              // ✅ ADDED
            'duty_shift' => 'sometimes|required|string|max:255',
            'email' => 'nullable|email|max:255|unique:staff,email,' . $id,
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric',
            'status' => 'nullable|in:active,inactive',
            'remarks' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048'
        ]);

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old picture
            if ($staff->profile_picture) {
                Storage::disk('public')->delete($staff->profile_picture);
            }
            $path = $request->file('profile_picture')->store('staff_profiles', 'public');
            $validated['profile_picture'] = $path;
        }

        $staff->update($validated);

        return redirect()->route('staff_records')
                         ->with('success', 'Staff member updated successfully!');
    }

    /**
     * Delete a staff member.
     */
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);
        
        // Delete profile picture if exists
        if ($staff->profile_picture) {
            Storage::disk('public')->delete($staff->profile_picture);
        }
        
        $staff->delete();

        return redirect()->route('staff_records')
                         ->with('success', 'Staff member deleted successfully!');
    }

    /**
     * Search staff (AJAX).
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        $staff = Staff::search($search)->limit(10)->get();
        return response()->json($staff);
    }
}