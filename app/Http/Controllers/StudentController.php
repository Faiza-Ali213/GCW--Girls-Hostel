<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = Student::query()->with('room');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('hostel_status', $request->status);
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get statistics
        $totalStudents = Student::count();
        $activeStudents = Student::active()->count();
        $totalRooms = Student::distinct('room_number')->count();

        return view('Pages.Admin.student_records', compact('students', 'totalStudents', 'activeStudents', 'totalRooms'));
    }

    /**
     * Show form to create new student.
     */
    public function create()
    {
        return view('Component.Admin.add_student');
    }

    /**
     * Store a new student.
     */
    public function store(Request $request)
    {
        // Step 1: Validation
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'cnic_number' => [
                'required',
                'string',
                'max:15',
                'unique:students',
                'regex:/^[0-9]{5}-?[0-9]{7}-?[0-9]{1}$/',   // ✅ 13 digits CNIC only
            ],
            'address' => 'required|string',
            'email' => 'nullable|email|max:255|unique:students',
            'room_number' => 'nullable|string|max:50',
            'room_id' => 'nullable|exists:rooms,id',
            'room_type' => 'nullable|string|in:double,triple,quad',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'hostel_status' => 'nullable|in:active,inactive,graduated,left',
            'guardian_contact' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'admission_date' => 'nullable|date',
            'medical_conditions' => 'nullable|string',
            'remarks' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048'
        ], [
            // ✅ Custom CNIC error messages
            'cnic_number.regex' => 'CNIC 13 digits ka hona chahiye (e.g., 34101-1234567-8)',
            'cnic_number.required' => 'CNIC number zaroori hai',
            'cnic_number.unique' => 'Ye CNIC pehle se registered hai',
            'cnic_number.max' => 'CNIC maximum 15 characters ka hona chahiye',
        ]);

        // Step 2: If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validated = $validator->validated();

        try {
            // Step 3: Handle profile picture upload
            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('student_profiles', 'public');
                $validated['profile_picture'] = $path;
            }

            // Step 4: Room validation and assignment
            if ($request->filled('room_id')) {
                $room = Room::find($request->room_id);

                if ($room) {
                    if (!$room->hasAvailableBeds()) {
                        return redirect()->back()
                            ->with('error', 'Room ' . $room->room_number . ' is already full.')
                            ->withInput();
                    }

                    $validated['room_id'] = $room->id;
                    $validated['room_number'] = $room->room_number;
                    $validated['room_type'] = $room->room_type;

                    $room->incrementOccupancy();
                }
            } else {
                if ($request->filled('room_number')) {
                    $room = Room::where('room_number', $request->room_number)->first();

                    if (!$room) {
                        return redirect()->back()
                            ->with('error', 'Room number ' . $request->room_number . ' does not exist in the system.')
                            ->withInput();
                    }

                    if (!$room->hasAvailableBeds()) {
                        return redirect()->back()
                            ->with('error', 'Room ' . $request->room_number . ' is already full.')
                            ->withInput();
                    }

                    $validated['room_id'] = $room->id;
                    $validated['room_type'] = $room->room_type;

                    $room->incrementOccupancy();
                }
            }

            // Step 5: Create student
            Student::create($validated);

            return redirect()->route('student-records')
                ->with('success', 'Student added successfully! ✅');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add student: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show a specific student.
     */
    public function show($id)
    {
        $student = Student::with('room')->findOrFail($id);
        return view('Component.Admin.view_student', ['student' => $student]);
    }

    /**
     * Get rooms by room type for dropdown (AJAX).
     */
    public function getRoomsByType(Request $request)
    {
        $roomType = $request->room_type;
        
        if (empty($roomType)) {
            return response()->json([
                'success' => false,
                'message' => 'Room type is required'
            ], 400);
        }
        
        $rooms = Room::where('room_type', $roomType)
                      ->where('status', 'available')
                      ->where('current_occupancy', '<', 'capacity')
                      ->orderBy('room_number')
                      ->get(['id', 'room_number', 'block', 'floor', 'capacity', 'current_occupancy']);
        
        return response()->json([
            'success' => true,
            'data' => $rooms
        ]);
    }

    /**
     * Validate room availability (AJAX).
     */
    public function validateRoom(Request $request)
    {
        $roomNumber = $request->room_number;
        
        if (empty($roomNumber)) {
            return response()->json([
                'success' => false,
                'message' => 'Room number is required'
            ], 400);
        }
        
        $room = Room::where('room_number', $roomNumber)->first();
        
        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Room ' . $roomNumber . ' does not exist in the system.'
            ]);
        }
        
        if ($room->current_occupancy >= $room->capacity) {
            return response()->json([
                'success' => true,
                'message' => 'Room is full',
                'data' => $room
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Room is available',
            'data' => $room
        ]);
    }

    /**
     * Show form to edit student.
     */
    public function edit($id)
    {
        $student = Student::with('room')->findOrFail($id);
        
        $rooms = Room::where('status', 'available')
                      ->where('current_occupancy', '<', 'capacity')
                      ->orderBy('room_number')
                      ->get();
        
        return view('Component.Admin.edit_student', compact('student', 'rooms'));
    }

    /**
     * Update a student.
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'student_name' => 'sometimes|required|string|max:255',
            'father_name' => 'sometimes|required|string|max:255',
            'phone_number' => 'sometimes|required|string|max:20',
            'cnic_number' => [
                'sometimes',
                'required',
                'string',
                'max:15',
                'unique:students,cnic_number,' . $id,
                'regex:/^[0-9]{5}-?[0-9]{7}-?[0-9]{1}$/',   // ✅ 13 digits CNIC only
            ],
            'address' => 'sometimes|required|string',
            'email' => 'nullable|email|max:255|unique:students,email,' . $id,
            'room_number' => 'nullable|string|max:50',
            'room_id' => 'nullable|exists:rooms,id',
            'room_type' => 'nullable|string|in:double,triple,quad',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'hostel_status' => 'nullable|in:active,inactive,graduated,left',
            'guardian_contact' => 'nullable|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'admission_date' => 'nullable|date',
            'medical_conditions' => 'nullable|string',
            'remarks' => 'nullable|string',
            'profile_picture' => 'nullable|image|max:2048'
        ], [
            // ✅ Custom CNIC error messages
            'cnic_number.regex' => 'CNIC 13 digits ka hona chahiye (e.g., 34101-1234567-8)',
            'cnic_number.required' => 'CNIC number zaroori hai',
            'cnic_number.unique' => 'Ye CNIC pehle se registered hai',
            'cnic_number.max' => 'CNIC maximum 15 characters ka hona chahiye',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            $path = $request->file('profile_picture')->store('student_profiles', 'public');
            $validated['profile_picture'] = $path;
        }

        if ($request->filled('room_id') && $request->room_id != $student->room_id) {
            if ($student->room_id) {
                $oldRoom = Room::find($student->room_id);
                if ($oldRoom) {
                    $oldRoom->decrementOccupancy();
                }
            }
            
            $newRoom = Room::find($request->room_id);
            if ($newRoom && $newRoom->hasAvailableBeds()) {
                $validated['room_id'] = $newRoom->id;
                $validated['room_number'] = $newRoom->room_number;
                $validated['room_type'] = $newRoom->room_type;
                $newRoom->incrementOccupancy();
            } else {
                return redirect()->back()
                    ->with('error', 'Selected room is not available or full.')
                    ->withInput();
            }
        } elseif ($request->filled('room_number') && $request->room_number != $student->room_number) {
            $newRoom = Room::where('room_number', $request->room_number)->first();
            if ($newRoom && $newRoom->hasAvailableBeds()) {
                if ($student->room_id) {
                    $oldRoom = Room::find($student->room_id);
                    if ($oldRoom) {
                        $oldRoom->decrementOccupancy();
                    }
                }
                
                $validated['room_id'] = $newRoom->id;
                $validated['room_type'] = $newRoom->room_type;
                $newRoom->incrementOccupancy();
            } else {
                return redirect()->back()
                    ->with('error', 'Room ' . $request->room_number . ' is not available or full.')
                    ->withInput();
            }
        } elseif (empty($request->room_number) && empty($request->room_id) && $student->room_id) {
            $oldRoom = Room::find($student->room_id);
            if ($oldRoom) {
                $oldRoom->decrementOccupancy();
            }
            $validated['room_id'] = null;
            $validated['room_type'] = null;
        }

        $student->update($validated);

        return redirect()->route('student-records')
                         ->with('success', 'Student updated successfully!');
    }

    /**
     * Delete a student.
     */
    public function destroy($id)
    {
        try {
            $student = Student::findOrFail($id);
            
            if ($student->room_id) {
                $room = Room::find($student->room_id);
                if ($room) {
                    $room->decrementOccupancy();
                }
            }
            
            if ($student->profile_picture) {
                Storage::disk('public')->delete($student->profile_picture);
            }
            
            $student->delete();

            return redirect()->route('student-records')
                             ->with('success', 'Student "' . $student->student_name . '" deleted successfully!');

        } catch (\Exception $e) {
            return redirect()->route('student-records')
                             ->with('error', 'Failed to delete student: ' . $e->getMessage());
        }
    }

    /**
     * Export students to CSV (optional).
     */
    public function export()
    {
        $students = Student::all();
        return redirect()->back()->with('success', 'Export started!');
    }

    /**
     * Get students by room number.
     */
    public function getByRoom($roomNumber)
    {
        $students = Student::byRoom($roomNumber)->get();
        return response()->json($students);
    }

    /**
     * Search students for visitor form (AJAX).
     */
    public function searchStudents(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }
        
        $students = Student::where('student_name', 'LIKE', "%{$query}%")
                           ->orWhere('cnic_number', 'LIKE', "%{$query}%")
                           ->orWhere('phone_number', 'LIKE', "%{$query}%")
                           ->orWhere('father_name', 'LIKE', "%{$query}%")
                           ->limit(10)
                           ->get(['id', 'student_name', 'father_name', 'room_number', 'phone_number', 'cnic_number']);
        
        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }
}