<?php
// app/Http/Controllers/FeeRecordController.php

namespace App\Http\Controllers;

use App\Models\FeeRecord;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeeRecordController extends Controller
{
    const DEFAULT_FEE_AMOUNT = 30000;

    /**
     * Display a listing of the fee records.
     */
    public function index(Request $request)
    {
        // Get all students and sync with fee records
        $this->syncStudentsWithFeeRecords();

        $query = FeeRecord::query();

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'LIKE', "%{$search}%")
                  ->orWhere('room_no', 'LIKE', "%{$search}%")
                  ->orWhere('phone_number', 'LIKE', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('fee_status', $request->status);
        }

        $feeRecords = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get statistics
        $totalRecords = FeeRecord::count();
        $totalPaid = FeeRecord::where('fee_status', 'paid')->count();
        $totalUnpaid = FeeRecord::where('fee_status', 'pending')->count();
        $totalPartial = FeeRecord::where('fee_status', 'partial')->count();

        return view('Pages.Admin.fee_record', compact(
            'feeRecords', 
            'totalRecords', 
            'totalPaid', 
            'totalUnpaid', 
            'totalPartial'
        ));
    }

    /**
     * Sync all students with fee records
     * Creates fee records for students who don't have one
     */
    private function syncStudentsWithFeeRecords()
    {
        $students = Student::all();
        $createdCount = 0;
        
        foreach ($students as $student) {
            // Check if student already has a fee record
            $exists = FeeRecord::where('student_name', $student->student_name)
                               ->where('phone_number', $student->phone_number)
                               ->exists();
            
            if (!$exists) {
                $feeRecord = FeeRecord::create([
                    'student_name' => $student->student_name,
                    'room_no' => $student->room_number ?? 'N/A',
                    'phone_number' => $student->phone_number,
                    'fee_amount' => self::DEFAULT_FEE_AMOUNT,
                    'paid_amount' => 0,
                    'pending_amount' => self::DEFAULT_FEE_AMOUNT,
                    'fee_status' => 'pending',
                    'payment_date' => null,
                    'payment_method' => 'cash', // Default payment method
                    'remarks' => 'Auto-generated from student record',
                ]);
                
                // Send notification for new fee record
                NotificationController::notifyFeeRecordCreated($feeRecord);
                $createdCount++;
            }
        }
        
        if ($createdCount > 0) {
            NotificationController::notifyFeeSyncCompleted($createdCount);
        }
    }

    /**
     * Show the form for creating a new fee record.
     */
    public function create()
    {
        $students = Student::all();
        return view('Component.Admin.add_fees', compact('students'));
    }

    /**
     * Store a newly created fee record.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_name' => 'required|string|max:255',
            'room_no' => 'required|string|max:50',
            'phone_number' => 'required|string|max:20',
            'fee_amount' => 'required|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $paidAmount = $request->paid_amount ?? 0;
            $feeAmount = $request->fee_amount ?? self::DEFAULT_FEE_AMOUNT;
            
            // Determine status
            $status = 'pending';
            if ($paidAmount >= $feeAmount) {
                $status = 'paid';
            } elseif ($paidAmount > 0 && $paidAmount < $feeAmount) {
                $status = 'partial';
            }

            $feeRecord = FeeRecord::create([
                'student_name' => $request->student_name,
                'room_no' => $request->room_no,
                'phone_number' => $request->phone_number,
                'fee_amount' => $feeAmount,
                'paid_amount' => $paidAmount,
                'pending_amount' => $feeAmount - $paidAmount,
                'fee_status' => $status,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method ?? 'cash', // Default to cash
                'remarks' => $request->remarks,
            ]);

            // Send notification
            NotificationController::notifyFeeRecordCreated($feeRecord);
            if ($paidAmount > 0) {
                NotificationController::notifyFeePaymentReceived($feeRecord, $paidAmount);
            }

            return redirect()->route('fee_record')
                ->with('success', 'Fee record created successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create fee record: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified fee record.
     */
    public function show($id)
    {
        try {
            $feeRecord = FeeRecord::findOrFail($id);
            return view('Component.Admin.view_fee', compact('feeRecord'));
        } catch (\Exception $e) {
            return redirect()->route('fee_record')
                ->with('error', 'Fee record not found');
        }
    }

    /**
     * Show the form for editing the specified fee record.
     */
    public function edit($id)
    {
        $feeRecord = FeeRecord::findOrFail($id);
        return view('Component.Admin.edit_fee', compact('feeRecord'));
    }

    /**
     * Update the specified fee record - ONLY FEE AMOUNT UPDATE.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paid_amount' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'payment_method' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $feeRecord = FeeRecord::findOrFail($id);
            
            $oldStatus = $feeRecord->fee_status;
            $paidAmount = $request->paid_amount ?? 0;
            $feeAmount = $feeRecord->fee_amount;
            $pendingAmount = $feeAmount - $paidAmount;
            
            // Determine status
            $status = 'pending';
            if ($paidAmount >= $feeAmount) {
                $status = 'paid';
            } elseif ($paidAmount > 0 && $paidAmount < $feeAmount) {
                $status = 'partial';
            }

            $feeRecord->update([
                'paid_amount' => $paidAmount,
                'pending_amount' => $pendingAmount,
                'fee_status' => $status,
                'payment_date' => $request->payment_date ?? now(),
                'payment_method' => $request->payment_method ?? 'cash', // Default to cash
                'remarks' => $request->remarks,
            ]);

            // Send notifications
            if ($oldStatus != $status) {
                NotificationController::notifyFeeStatusUpdated($feeRecord, $oldStatus);
            }
            if ($paidAmount > 0) {
                NotificationController::notifyFeePaymentReceived($feeRecord, $paidAmount);
            }

            return redirect()->route('fee_record')
                ->with('success', 'Fee payment updated successfully for ' . $feeRecord->student_name . '!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update fee: ' . $e->getMessage());
        }
    }

    /**
     * Show fee payment form
     */
    public function pay($id)
    {
        try {
            $feeRecord = FeeRecord::findOrFail($id);
            return view('Component.Admin.pay_fee', compact('feeRecord'));
        } catch (\Exception $e) {
            return redirect()->route('fee_record')
                ->with('error', 'Fee record not found');
        }
    }

    /**
     * Process fee payment
     */
    public function processPayment(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paid_amount' => 'required|numeric|min:1',
            'payment_method' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $feeRecord = FeeRecord::findOrFail($id);
            
            $oldStatus = $feeRecord->fee_status;
            $paidAmount = $feeRecord->paid_amount + $request->paid_amount;
            $feeAmount = $feeRecord->fee_amount;
            $pendingAmount = $feeAmount - $paidAmount;
            
            // Determine status
            $status = 'pending';
            if ($paidAmount >= $feeAmount) {
                $status = 'paid';
            } elseif ($paidAmount > 0 && $paidAmount < $feeAmount) {
                $status = 'partial';
            }

            $feeRecord->update([
                'paid_amount' => $paidAmount,
                'pending_amount' => $pendingAmount,
                'fee_status' => $status,
                'payment_date' => now(),
                'payment_method' => $request->payment_method ?? 'cash', // Default to cash
                'remarks' => $request->remarks,
            ]);

            // Send notifications
            if ($oldStatus != $status) {
                NotificationController::notifyFeeStatusUpdated($feeRecord, $oldStatus);
            }
            NotificationController::notifyFeePaymentReceived($feeRecord, $request->paid_amount);

            return redirect()->route('fee-record.receipt', $feeRecord->id)
                ->with('success', 'Payment of PKR ' . number_format($request->paid_amount, 2) . ' received successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    /**
     * Show fee receipt
     */
    public function receipt($id)
    {
        try {
            $feeRecord = FeeRecord::findOrFail($id);
            return view('Component.Admin.fee_receipt', compact('feeRecord'));
        } catch (\Exception $e) {
            return redirect()->route('fee_record')
                ->with('error', 'Fee record not found');
        }
    }

    /**
     * Remove the specified fee record.
     */
    public function destroy($id)
    {
        try {
            $feeRecord = FeeRecord::findOrFail($id);
            $feeRecord->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Fee record deleted successfully!'
                ]);
            }

            return redirect()->route('fee_record')
                ->with('success', 'Fee record deleted successfully!');

        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete fee record: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('fee_record')
                ->with('error', 'Failed to delete fee record: ' . $e->getMessage());
        }
    }

    /**
     * Update fee status only.
     */
    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'fee_status' => 'required|in:paid,pending,partial',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $feeRecord = FeeRecord::findOrFail($id);
            $oldStatus = $feeRecord->fee_status;
            
            $feeRecord->fee_status = $request->fee_status;
            
            if ($request->has('paid_amount')) {
                $feeRecord->paid_amount = $request->paid_amount;
                $feeRecord->pending_amount = $feeRecord->fee_amount - $request->paid_amount;
            }
            
            $feeRecord->save();

            // Send notification
            if ($oldStatus != $feeRecord->fee_status) {
                NotificationController::notifyFeeStatusUpdated($feeRecord, $oldStatus);
            }

            return response()->json([
                'success' => true,
                'message' => 'Fee status updated successfully!',
                'data' => $feeRecord
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get summary statistics.
     */
    public function getSummary()
    {
        $totalRecords = FeeRecord::count();
        $totalPaid = FeeRecord::where('fee_status', 'paid')->count();
        $totalPending = FeeRecord::where('fee_status', 'pending')->count();
        $totalPartial = FeeRecord::where('fee_status', 'partial')->count();
        $totalAmount = FeeRecord::sum('fee_amount');
        $totalPaidAmount = FeeRecord::sum('paid_amount');
        $totalPendingAmount = FeeRecord::sum('pending_amount');

        return response()->json([
            'success' => true,
            'data' => [
                'total_records' => $totalRecords,
                'total_paid' => $totalPaid,
                'total_pending' => $totalPending,
                'total_partial' => $totalPartial,
                'total_amount' => $totalAmount,
                'total_paid_amount' => $totalPaidAmount,
                'total_pending_amount' => $totalPendingAmount,
            ]
        ]);
    }

    /**
     * Bulk sync students to fee records
     */
    public function syncAllStudents()
    {
        $this->syncStudentsWithFeeRecords();
        
        return redirect()->route('fee_record')
            ->with('success', 'All students synced with fee records successfully!');
    }
}