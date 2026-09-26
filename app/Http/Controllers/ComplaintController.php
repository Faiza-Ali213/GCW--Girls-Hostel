<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class ComplaintController extends Controller
{
    /**
     * Display a listing of complaints (Admin Panel).
     */
    public function index(Request $request)
    {
        $query = Complaint::query();

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'LIKE', "%{$search}%")
                  ->orWhere('title', 'LIKE', "%{$search}%")
                  ->orWhere('complaint_by', 'LIKE', "%{$search}%")
                  ->orWhere('room_number', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->has('priority') && !empty($request->priority)) {
            $query->where('priority', $request->priority);
        }

        $complaints = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics
        $totalComplaints = Complaint::count();
        $pendingComplaints = Complaint::pending()->count();
        $inProgressComplaints = Complaint::inProgress()->count();
        $resolvedComplaints = Complaint::resolved()->count();
        $rejectedComplaints = Complaint::where('status', 'rejected')->count();

        return view('Pages.Admin.Complain_request', compact(
            'complaints',
            'totalComplaints',
            'pendingComplaints',
            'inProgressComplaints',
            'resolvedComplaints',
            'rejectedComplaints'
        ));
    }

    /**
     * Show complaint registration form.
     */
    public function create()
    {
        return view('Pages.complaint_registration');
    }

    /**
     * Store a newly created complaint.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'student_email' => 'nullable|email|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10',
            'room_number' => 'nullable|string|max:50',
            'contact_number' => 'nullable|string|max:20',
            'complaint_by' => 'nullable|string|max:255',
            'priority' => 'nullable|in:low,medium,high',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // ✅ Check karein ke user_id column mojood hai ya nahi
            $hasUserIdColumn = Schema::hasColumn('complaints', 'user_id');

            $data = [
                'student_name' => $request->student_name,
                'student_email' => $request->student_email,
                'title' => $request->title,
                'description' => $request->description,
                'room_number' => $request->room_number,
                'contact_number' => $request->contact_number,
                'complaint_by' => $request->complaint_by ?? $request->student_name,
                'priority' => $request->priority ?? 'medium',
                'status' => 'pending',
            ];

            // ✅ Sirf tab user_id add karein jab column mojood ho
            if ($hasUserIdColumn && auth()->check()) {
                $data['user_id'] = auth()->id();
            }

            Complaint::create($data);

            return redirect()->route('complaint.registration')
                ->with('success', 'Your complaint has been submitted successfully! We will review it shortly.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to submit complaint: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified complaint.
     */
    public function show($id)
    {
        try {
            $complaint = Complaint::findOrFail($id);
            return view('Component.Admin.view_complain', compact('complaint'));
        } catch (\Exception $e) {
            return redirect()->route('complaints.index')
                ->with('error', 'Complaint not found');
        }
    }

    /**
     * Show form to update complaint status.
     */
    public function edit($id)
    {
        try {
            $complaint = Complaint::findOrFail($id);
            return view('Component.Admin.edit_complaint', compact('complaint'));
        } catch (\Exception $e) {
            return redirect()->route('complaints.index')
                ->with('error', 'Complaint not found');
        }
    }

    /**
     * Update the specified complaint.
     * Handles both individual and bulk status updates.
     */
    public function update(Request $request)
    {
        $statuses = $request->statuses;

        if (empty($statuses)) {
            return redirect()->route('complaints.index')
                ->with('error', 'No status changes to update.');
        }

        $updatedCount = 0;
        $errors = [];

        foreach ($statuses as $id => $status) {
            try {
                $complaint = Complaint::find($id);
                if ($complaint) {
                    $updateData = ['status' => $status];
                    
                    if ($status == 'resolved') {
                        $updateData['resolved_at'] = now();
                    }
                    
                    $complaint->update($updateData);
                    $updatedCount++;
                }
            } catch (\Exception $e) {
                $errors[] = 'Failed to update complaint #' . $id . ': ' . $e->getMessage();
            }
        }

        if ($updatedCount > 0 && empty($errors)) {
            return redirect()->route('complaints.index')
                ->with('success', $updatedCount . ' complaint(s) status updated successfully!');
        } elseif ($updatedCount > 0 && !empty($errors)) {
            return redirect()->route('complaints.index')
                ->with('warning', $updatedCount . ' complaint(s) updated, but some failed: ' . implode(', ', $errors));
        } else {
            return redirect()->route('complaints.index')
                ->with('error', 'Failed to update statuses: ' . implode(', ', $errors));
        }
    }

    /**
     * Remove the specified complaint.
     */
    public function destroy($id)
    {
        try {
            $complaint = Complaint::findOrFail($id);
            $complaint->delete();

            return redirect()->route('complaints.index')
                ->with('success', 'Complaint deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('complaints.index')
                ->with('error', 'Failed to delete complaint: ' . $e->getMessage());
        }
    }

    /**
     * ✅ Show student's own complaints with live status
     * Accessible by ALL logged-in users (not restricted to admin)
     */
    public function myComplaints()
    {
        $user = auth()->user();

        // ✅ Check karein ke user_id column mojood hai ya nahi
        $hasUserIdColumn = Schema::hasColumn('complaints', 'user_id');

        if ($hasUserIdColumn) {
            // ✅ Agar user_id column mojood hai toh us se match karein
            $baseQuery = Complaint::where('user_id', $user->id);
        } else {
            // ✅ Agar user_id column nahi hai toh email se match karein
            $baseQuery = Complaint::where('student_email', $user->email);
        }

        // Paginated complaints
        $complaints = (clone $baseQuery)->orderBy('created_at', 'desc')->paginate(10);

        // Statistics
        $totalComplaints = (clone $baseQuery)->count();
        $pendingCount = (clone $baseQuery)->where('status', 'pending')->count();
        $inProgressCount = (clone $baseQuery)->where('status', 'in_progress')->count();
        $resolvedCount = (clone $baseQuery)->where('status', 'resolved')->count();

        return view('Pages.my-complaints', compact(
            'complaints',
            'totalComplaints',
            'pendingCount',
            'inProgressCount',
            'resolvedCount'
        ));
    }
}