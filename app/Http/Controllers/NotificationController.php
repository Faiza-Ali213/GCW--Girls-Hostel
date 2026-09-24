<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Complaint;
use App\Models\FeeRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // Display all notifications
    public function index(Request $request)
    {
        // ✅ UPDATED: By default saari notifications (read + unread) show hongi
        $query = Notification::query()
            ->where(function($q) {
                $q->where('is_global', true)
                  ->orWhere('user_id', Auth::id());
            })
            ->active();

        // Filter by status (sirf tab jab user khud filter kare)
        if ($request->status == 'unread') {
            $query->unread();
        } elseif ($request->status == 'read') {
            $query->read();
        }
        // ✅ Agar koi filter nahi lagaya, toh saari (read + unread) show hongi

        // Filter by type
        if ($request->type && in_array($request->type, ['info', 'success', 'warning', 'error'])) {
            $query->where('type', $request->type);
        }

        // Get total count before pagination
        $totalCount = $query->count();
        
        // ✅ 5 notifications per page
        $notifications = $query->latest()->paginate(5);
        
        // Count unread for badge
        $unreadCount = Notification::unread()
            ->forUser(Auth::id())
            ->active()
            ->count();

        return view('Pages.Admin.Notification', compact('notifications', 'unreadCount', 'totalCount'));
    }

    // Show create form
    public function create()
    {
        return view('notifications.create');
    }

    // Store new notification
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,error',
            'icon' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:255',
            'user_id' => 'nullable|exists:users,id',
            'is_global' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $validated['is_global'] = $request->has('is_global') && !$request->user_id;
        $validated['user_id'] = $request->is_global ? null : $request->user_id;

        Notification::create($validated);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification created successfully!');
    }

    // Show single notification
    public function show(Notification $notification)
    {
        if (!$notification->is_read) {
            $notification->markAsRead();
        }

        return view('notifications.show', compact('notification'));
    }

    // Show edit form
    public function edit(Notification $notification)
    {
        return view('notifications.edit', compact('notification'));
    }

    // Update notification
    public function update(Request $request, Notification $notification)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,success,warning,error',
            'icon' => 'nullable|string|max:100',
            'link' => 'nullable|url|max:255',
            'user_id' => 'nullable|exists:users,id',
            'is_global' => 'boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $validated['is_global'] = $request->has('is_global') && !$request->user_id;
        $validated['user_id'] = $request->is_global ? null : $request->user_id;

        $notification->update($validated);

        return redirect()->route('notifications.index')
            ->with('success', 'Notification updated successfully!');
    }

    // Delete notification
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('notifications.index')
            ->with('success', 'Notification deleted successfully!');
    }

    // Mark notification as read (AJAX)
    public function markAsRead(Request $request, Notification $notification)
    {
        $notification->markAsRead();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notification marked as read!');
    }

    // Mark notification as unread (AJAX)
    public function markAsUnread(Request $request, Notification $notification)
    {
        $notification->markAsUnread();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'Notification marked as unread!');
    }

    // Mark all as read
    public function markAllAsRead(Request $request)
    {
        Notification::forUser(Auth::id())
            ->unread()
            ->active()
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'All notifications marked as read!');
    }

    // Clear all read notifications
    public function clearAll(Request $request)
    {
        Notification::forUser(Auth::id())
            ->read()
            ->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back()->with('success', 'All read notifications cleared!');
    }

    // Get unread notifications count (AJAX)
    public function getUnreadCount(Request $request)
    {
        if (Auth::check()) {
            $count = Notification::unread()
                ->forUser(Auth::id())
                ->active()
                ->count();

            return response()->json(['count' => $count]);
        }

        return response()->json(['count' => 0]);
    }

    // Get latest notifications for AJAX
    public function getLatest(Request $request)
    {
        $limit = $request->limit ?? 5;
        
        $notifications = Notification::forUser(Auth::id())
            ->active()
            ->latest()
            ->limit($limit)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => Notification::unread()
                ->forUser(Auth::id())
                ->active()
                ->count()
        ]);
    }

    // ============================================
    // USER NOTIFICATIONS
    // ============================================

    public static function notifyUserCreated(User $user)
    {
        $roleLabels = [
            'admin' => 'Administrator',
            'warden' => 'Warden',
            'user' => 'User'
        ];
        $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);
        
        Notification::create([
            'title' => 'New User Registered',
            'message' => "A new user '{$user->name}' has been registered as '{$roleLabel}'",
            'type' => 'success',
            'icon' => 'bi-person-plus',
            'link' => route('users.show', $user->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public static function notifyUserStatusChanged(User $user)
    {
        $statusLabel = ucfirst($user->status);
        
        Notification::create([
            'title' => 'User Status Updated',
            'message' => "User '{$user->name}' status has been changed to '{$statusLabel}'",
            'type' => $user->status == 'active' ? 'success' : 'warning',
            'icon' => $user->status == 'active' ? 'bi-person-check' : 'bi-person-x',
            'link' => route('users.show', $user->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public static function notifyUserRoleChanged(User $user)
    {
        $roleLabels = [
            'admin' => 'Administrator',
            'warden' => 'Warden',
            'user' => 'User'
        ];
        $roleLabel = $roleLabels[$user->role] ?? ucfirst($user->role);
        
        Notification::create([
            'title' => 'User Role Updated',
            'message' => "User '{$user->name}' role has been changed to '{$roleLabel}'",
            'type' => 'info',
            'icon' => 'bi-person-badge',
            'link' => route('users.show', $user->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    // ============================================
    // VISITOR NOTIFICATIONS
    // ============================================

    public static function notifyVisitorAdded(Visitor $visitor)
    {
        $message = "New visitor '{$visitor->visitor_name}' has checked in";
        
        if ($visitor->student_name) {
            $message .= " to meet '{$visitor->student_name}'";
        }
        
        if ($visitor->purpose_of_visit) {
            $message .= " (Purpose: {$visitor->purpose_of_visit})";
        }

        Notification::create([
            'title' => 'New Visitor Arrived',
            'message' => $message,
            'type' => 'info',
            'icon' => 'bi-person-check',
            'link' => route('visitor.show', $visitor->id),
            'is_global' => true,
            'expires_at' => now()->addDays(3),
        ]);
    }

    public static function notifyVisitorCheckedOut(Visitor $visitor)
    {
        $duration = 'N/A';
        if ($visitor->check_in_time && $visitor->check_out_time) {
            $duration = $visitor->check_in_time->diffForHumans($visitor->check_out_time);
        } elseif ($visitor->check_in_time) {
            $duration = $visitor->check_in_time->diffForHumans(now());
        }
        
        Notification::create([
            'title' => 'Visitor Checked Out',
            'message' => "Visitor '{$visitor->visitor_name}' has checked out. Duration: {$duration}",
            'type' => 'info',
            'icon' => 'bi-person-check',
            'link' => route('visitor.show', $visitor->id),
            'is_global' => true,
            'expires_at' => now()->addDays(3),
        ]);
    }

    // ============================================
    // COMPLAINT NOTIFICATIONS
    // ============================================

    public static function notifyComplaintSubmitted(Complaint $complaint)
    {
        $studentName = $complaint->student ? $complaint->student->name : $complaint->student_name;
        $priorityLabels = [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High'
        ];
        $priorityLabel = $priorityLabels[$complaint->priority] ?? ucfirst($complaint->priority);
        
        Notification::create([
            'title' => 'New Complaint Submitted',
            'message' => "Complaint #{$complaint->id} submitted by '{$studentName}' with {$priorityLabel} priority",
            'type' => $complaint->priority == 'high' ? 'warning' : 'info',
            'icon' => $complaint->priority == 'high' ? 'bi-exclamation-triangle' : 'bi-file-earmark-text',
            'link' => route('complaints.show', $complaint->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public static function notifyComplaintUpdated(Complaint $complaint)
    {
        $statusLabels = [
            'pending' => 'Pending Review',
            'processing' => 'In Progress',
            'resolved' => 'Resolved',
            'rejected' => 'Rejected'
        ];
        
        $statusLabel = $statusLabels[$complaint->status] ?? ucfirst($complaint->status);
        $studentName = $complaint->student ? $complaint->student->name : $complaint->student_name;
        
        $type = 'info';
        $icon = 'bi-arrow-repeat';
        
        if ($complaint->status == 'resolved') {
            $type = 'success';
            $icon = 'bi-check-circle';
        } elseif ($complaint->status == 'rejected') {
            $type = 'error';
            $icon = 'bi-x-circle';
        }
        
        Notification::create([
            'title' => 'Complaint Status Updated',
            'message' => "Complaint #{$complaint->id} from '{$studentName}' is now '{$statusLabel}'",
            'type' => $type,
            'icon' => $icon,
            'link' => route('complaints.show', $complaint->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    // ============================================
    // FEE RECORD NOTIFICATIONS
    // ============================================

    public static function notifyFeeRecordCreated(FeeRecord $feeRecord)
    {
        $statusLabels = [
            'paid' => 'Paid',
            'pending' => 'Pending',
            'partial' => 'Partial'
        ];
        $statusLabel = $statusLabels[$feeRecord->fee_status] ?? ucfirst($feeRecord->fee_status);
        $statusEmojis = [
            'paid' => '✅',
            'pending' => '🟠',
            'partial' => '🟡'
        ];
        $emoji = $statusEmojis[$feeRecord->fee_status] ?? '📝';
        
        Notification::create([
            'title' => 'New Fee Record Created',
            'message' => "{$emoji} Fee record for '{$feeRecord->student_name}' - Amount: PKR {$feeRecord->fee_amount} - Status: {$statusLabel}",
            'type' => $feeRecord->fee_status == 'paid' ? 'success' : 'info',
            'icon' => 'bi-wallet',
            'link' => route('fee-record.show', $feeRecord->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public static function notifyFeeStatusUpdated(FeeRecord $feeRecord, $oldStatus = null)
    {
        $statusLabels = [
            'paid' => 'Paid',
            'pending' => 'Pending',
            'partial' => 'Partial'
        ];
        $statusLabel = $statusLabels[$feeRecord->fee_status] ?? ucfirst($feeRecord->fee_status);
        $oldStatusLabel = $oldStatus ? ($statusLabels[$oldStatus] ?? ucfirst($oldStatus)) : null;
        
        $statusEmojis = [
            'paid' => '✅',
            'pending' => '🟠',
            'partial' => '🟡'
        ];
        $emoji = $statusEmojis[$feeRecord->fee_status] ?? '📝';
        
        $message = "{$emoji} Fee status updated for '{$feeRecord->student_name}'";
        $message .= " - Amount: PKR {$feeRecord->fee_amount}";
        $message .= " - Paid: PKR {$feeRecord->paid_amount}";
        $message .= " - Status: {$statusLabel}";
        
        if ($oldStatusLabel && $oldStatus != $feeRecord->fee_status) {
            $message .= " (was {$oldStatusLabel})";
        }

        $type = 'info';
        if ($feeRecord->fee_status == 'paid') {
            $type = 'success';
        } elseif ($feeRecord->fee_status == 'partial') {
            $type = 'warning';
        }
        
        Notification::create([
            'title' => 'Fee Status Updated',
            'message' => $message,
            'type' => $type,
            'icon' => 'bi-currency-exchange',
            'link' => route('fee-record.show', $feeRecord->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public static function notifyFeePaymentReceived(FeeRecord $feeRecord, $amount)
    {
        $statusLabels = [
            'paid' => 'Paid',
            'pending' => 'Pending',
            'partial' => 'Partial'
        ];
        $statusLabel = $statusLabels[$feeRecord->fee_status] ?? ucfirst($feeRecord->fee_status);
        
        $message = "💰 Payment of PKR {$amount} received from '{$feeRecord->student_name}'";
        $message .= " - Total Fee: PKR {$feeRecord->fee_amount}";
        $message .= " - Status: {$statusLabel}";
        $message .= " - Remaining: PKR {$feeRecord->pending_amount}";

        $type = 'success';
        if ($feeRecord->fee_status == 'partial') {
            $type = 'warning';
        }
        
        Notification::create([
            'title' => 'Fee Payment Received',
            'message' => $message,
            'type' => $type,
            'icon' => 'bi-cash-stack',
            'link' => route('fee-record.show', $feeRecord->id),
            'is_global' => true,
            'expires_at' => now()->addDays(7),
        ]);
    }

    public static function notifyFeeOverdue(FeeRecord $feeRecord)
    {
        $daysOverdue = $feeRecord->created_at ? $feeRecord->created_at->diffInDays(now()) : 0;
        
        Notification::create([
            'title' => '⚠️ Fee Overdue Alert',
            'message' => "Fee for '{$feeRecord->student_name}' is overdue by {$daysOverdue} days. Amount: PKR {$feeRecord->pending_amount}",
            'type' => 'error',
            'icon' => 'bi-exclamation-triangle',
            'link' => route('fee-record.show', $feeRecord->id),
            'is_global' => true,
            'expires_at' => now()->addDays(3),
        ]);
    }

    public static function notifyFeeSyncCompleted($count)
    {
        Notification::create([
            'title' => 'Fee Records Synced',
            'message' => "Successfully synced {$count} student records to fee records.",
            'type' => 'success',
            'icon' => 'bi-cloud-check',
            'link' => route('fee_record'),
            'is_global' => true,
            'expires_at' => now()->addDays(1),
        ]);
    }

    // ============================================
    // GENERIC NOTIFICATION HELPER
    // ============================================

    public static function createNotification($title, $message, $type = 'info', $icon = null, $link = null, $userId = null, $expiresAt = null)
    {
        return Notification::create([
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'icon' => $icon,
            'link' => $link,
            'user_id' => $userId,
            'is_global' => is_null($userId),
            'expires_at' => $expiresAt ?? now()->addDays(7),
        ]);
    }
}