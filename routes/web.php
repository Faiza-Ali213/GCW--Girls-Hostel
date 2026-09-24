<?php

use App\Http\Controllers\StaffController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RoomAllocationController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\VisitorController;
use App\Http\Controllers\FeeRecordController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\DashboardController;   // ✅ ADDED
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Password Reset Routes
|--------------------------------------------------------------------------
*/
Route::get('/forgot-password', function () {
    return view('Pages.Auth.forgot-password'); // ✅ CHANGED: auth -> Pages.Auth
})->name('password.request');

Route::post('/forgot-password', function () {
    return back()->with('status', 'Password reset link sent!');
})->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('Pages.Auth.reset-password', ['token' => $token]); // ✅ CHANGED: auth -> Pages.Auth
})->name('password.reset');

Route::post('/reset-password', function () {
    return redirect()->route('login')->with('status', 'Password reset successfully!');
})->name('password.update');

/*
|--------------------------------------------------------------------------
| Authentication Routes (Login, Signup, Logout)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login.submit');
    Route::get('/signup', [AuthenticationController::class, 'showSignupForm'])->name('signup');
    Route::post('/signup', [AuthenticationController::class, 'signup'])->name('signup.submit');
});

Route::post('/register', [AuthenticationController::class, 'signup'])->name('register.submit');

// Authenticated routes (require login)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');
    
    // ============================================
    // Profile Management Routes
    // ============================================
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::post('/profile/upload-photo', [ProfileController::class, 'uploadPhoto'])->name('profile.upload-photo');
    
    Route::get('/bookings', function () {
        return view('Pages.bookings');
    })->name('bookings');

    // ============================================
    // Admin & Warden Protected Routes
    // ============================================
    Route::middleware(\App\Http\Middleware\AdminOrWarden::class)->group(function () {
        
        // ✅ Dashboard (Dynamic with real stats)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ============================================
        // User Management Routes (Full CRUD)
        // ============================================
        Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
        Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
        Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
        Route::get('/users/{id}', [UserManagementController::class, 'show'])->name('users.show');
        Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
        Route::patch('/users/{id}/status', [UserManagementController::class, 'updateStatus'])->name('users.update-status');
        Route::get('/users/export', [UserManagementController::class, 'export'])->name('users.export');
        Route::get('/user-management', [UserManagementController::class, 'index'])->name('user_management');

        // ============================================
        // Student Management
        // ============================================
        Route::prefix('student')->name('student.')->group(function () {
            Route::get('/records', [StudentController::class, 'index'])->name('records');
            Route::get('/create', [StudentController::class, 'create'])->name('create');
            Route::post('/', [StudentController::class, 'store'])->name('store');
            Route::get('/{id}', [StudentController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [StudentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [StudentController::class, 'update'])->name('update');
            Route::delete('/{id}', [StudentController::class, 'destroy'])->name('destroy');
            Route::get('/export', [StudentController::class, 'export'])->name('export');
            Route::get('/by-room/{roomNumber}', [StudentController::class, 'getByRoom'])->name('by-room');
        });

        Route::get('/student-records', [StudentController::class, 'index'])->name('student-records');
        Route::get('/student-records/create', [StudentController::class, 'create'])->name('student-records.create');
        Route::post('/student-records', [StudentController::class, 'store'])->name('student-records.store');
        Route::get('/student-records/{id}', [StudentController::class, 'show'])->name('student-records.show');
        Route::get('/student-records/{id}/edit', [StudentController::class, 'edit'])->name('student-records.edit');
        Route::put('/student-records/{id}', [StudentController::class, 'update'])->name('student-records.update');
        Route::delete('/student-records/{id}', [StudentController::class, 'destroy'])->name('student-records.destroy');
        
        Route::get('/student/get-rooms-by-type', [StudentController::class, 'getRoomsByType'])->name('student.getRoomsByType');
        Route::get('/student/validate-room', [StudentController::class, 'validateRoom'])->name('student.validateRoom');
        Route::get('/student/search', [StudentController::class, 'searchStudents'])->name('student.search');

        // ============================================
        // Staff Management
        // ============================================
        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/records', [StaffController::class, 'index'])->name('records');
            Route::get('/', [StaffController::class, 'index'])->name('index');
            Route::get('/create', [StaffController::class, 'create'])->name('create');
            Route::post('/', [StaffController::class, 'store'])->name('store');
            Route::get('/{id}', [StaffController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [StaffController::class, 'edit'])->name('edit');
            Route::put('/{id}', [StaffController::class, 'update'])->name('update');
            Route::delete('/{id}', [StaffController::class, 'destroy'])->name('destroy');
            Route::get('/search', [StaffController::class, 'search'])->name('search');
        });

        Route::get('/staff-record', [StaffController::class, 'index'])->name('staff-record');
        Route::get('/staff-record/create', [StaffController::class, 'create'])->name('staff-record.create');
        Route::post('/staff-record', [StaffController::class, 'store'])->name('staff-record.store');
        Route::get('/staff-record/{id}', [StaffController::class, 'show'])->name('staff-record.show');
        Route::get('/staff-record/{id}/edit', [StaffController::class, 'edit'])->name('staff-record.edit');
        Route::put('/staff-record/{id}', [StaffController::class, 'update'])->name('staff-record.update');
        Route::delete('/staff-record/{id}', [StaffController::class, 'destroy'])->name('staff-record.destroy');

        Route::get('/staff_records', [StaffController::class, 'index'])->name('staff_records');
        Route::get('/staff_records/create', [StaffController::class, 'create'])->name('staff_records.create');
        Route::post('/staff_records', [StaffController::class, 'store'])->name('staff_records.store');
        Route::get('/staff_records/{id}', [StaffController::class, 'show'])->name('staff_records.show');
        Route::get('/staff_records/{id}/edit', [StaffController::class, 'edit'])->name('staff_records.edit');
        Route::put('/staff_records/{id}', [StaffController::class, 'update'])->name('staff_records.update');
        Route::delete('/staff_records/{id}', [StaffController::class, 'destroy'])->name('staff_records.destroy');

        // ============================================
        // Visitor Management
        // ============================================
        Route::prefix('visitor')->name('visitor.')->group(function () {
            Route::get('/records', [VisitorController::class, 'index'])->name('records');
            Route::get('/create', [VisitorController::class, 'create'])->name('create');
            Route::post('/', [VisitorController::class, 'store'])->name('store');
            Route::get('/{id}', [VisitorController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [VisitorController::class, 'edit'])->name('edit');
            Route::put('/{id}', [VisitorController::class, 'update'])->name('update');
            Route::delete('/{id}', [VisitorController::class, 'destroy'])->name('destroy');
            Route::get('/search', [VisitorController::class, 'search'])->name('search');
            Route::get('/export', [VisitorController::class, 'export'])->name('export');
            Route::post('/{id}/check-in', [VisitorController::class, 'checkIn'])->name('check-in');
            Route::post('/{id}/check-out', [VisitorController::class, 'checkOut'])->name('check-out');
        });

        Route::get('/visitors-records', [VisitorController::class, 'index'])->name('visitors_records');
        Route::get('/vistors-records', [VisitorController::class, 'index'])->name('vistors_records');
        Route::get('/visitor-record', [VisitorController::class, 'index'])->name('visitor-record');

        // ============================================
        // Complaint Management
        // ============================================
        Route::prefix('complaints')->name('complaints.')->group(function () {
            Route::get('/', [ComplaintController::class, 'index'])->name('index');
            Route::get('/create', [ComplaintController::class, 'create'])->name('create');
            Route::post('/', [ComplaintController::class, 'store'])->name('store');
            Route::get('/{id}', [ComplaintController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [ComplaintController::class, 'edit'])->name('edit');
            Route::put('/', [ComplaintController::class, 'update'])->name('update');
            Route::delete('/{id}', [ComplaintController::class, 'destroy'])->name('destroy');
        });

        Route::get('/complaint-request', [ComplaintController::class, 'index'])->name('complaint_request');
        Route::get('/Complain-request', [ComplaintController::class, 'index'])->name('Complain_request');
        Route::get('/complaint-management', [ComplaintController::class, 'index'])->name('complaint_management');
        Route::get('/complaint-record', [ComplaintController::class, 'index'])->name('complaint-record');

        // ============================================
        // Room Management
        // ============================================
        Route::prefix('room-allocation')->name('room-allocation.')->group(function () {
            Route::get('/', [RoomController::class, 'index'])->name('index');
            Route::get('/create', [RoomController::class, 'create'])->name('create');
            Route::post('/', [RoomController::class, 'store'])->name('store');
            Route::get('/{id}', [RoomController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [RoomController::class, 'edit'])->name('edit');
            Route::put('/{id}', [RoomController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoomController::class, 'destroy'])->name('destroy');
            Route::get('/available', [RoomController::class, 'getAvailableRooms'])->name('available');
            Route::patch('/{id}/status', [RoomController::class, 'updateStatus'])->name('update-status');
            Route::get('/details/{id}', [RoomController::class, 'getRoomDetails'])->name('details');
        });

        Route::get('/room_allocation', [RoomController::class, 'index'])->name('room_allocation');
        Route::get('/room-record', [RoomController::class, 'index'])->name('room-record');

        // ============================================
        // Fee Record Management
        // ============================================
        Route::prefix('fee-record')->name('fee-record.')->group(function () {
            Route::get('/', [FeeRecordController::class, 'index'])->name('index');
            Route::get('/create', [FeeRecordController::class, 'create'])->name('create');
            Route::get('/{id}', [FeeRecordController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [FeeRecordController::class, 'edit'])->name('edit');
            Route::post('/', [FeeRecordController::class, 'store'])->name('store');
            Route::put('/{id}', [FeeRecordController::class, 'update'])->name('update');
            Route::delete('/{id}', [FeeRecordController::class, 'destroy'])->name('destroy');
            Route::patch('/{id}/status', [FeeRecordController::class, 'updateStatus'])->name('update-status');
            Route::get('/summary', [FeeRecordController::class, 'getSummary'])->name('summary');
            
            Route::get('/{id}/pay', [FeeRecordController::class, 'pay'])->name('pay');
            Route::post('/{id}/process-payment', [FeeRecordController::class, 'processPayment'])->name('process-payment');
            Route::get('/{id}/receipt', [FeeRecordController::class, 'receipt'])->name('receipt');
        });

        Route::get('/fee_record', [FeeRecordController::class, 'index'])->name('fee_record');
        Route::get('/fee-records', [FeeRecordController::class, 'index'])->name('fee-records.index');
        Route::get('/fee-record-list', [FeeRecordController::class, 'index'])->name('fee-record-list');
        Route::post('/fee-records', [FeeRecordController::class, 'store'])->name('fee-records.store');
        Route::get('/fee-record/sync', [FeeRecordController::class, 'syncAllStudents'])->name('fee_record.sync');

        // ============================================
        // Notification Management
        // ============================================
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::get('/create', [NotificationController::class, 'create'])->name('create');
            Route::post('/', [NotificationController::class, 'store'])->name('store');
            Route::get('/{notification}', [NotificationController::class, 'show'])->name('show');
            Route::get('/{notification}/edit', [NotificationController::class, 'edit'])->name('edit');
            Route::put('/{notification}', [NotificationController::class, 'update'])->name('update');
            Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
            Route::post('/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
            Route::post('/{notification}/mark-as-unread', [NotificationController::class, 'markAsUnread'])->name('mark-as-unread');
            Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
            Route::delete('/clear-all', [NotificationController::class, 'clearAll'])->name('clear-all');
            Route::get('/unread-count', [NotificationController::class, 'getUnreadCount'])->name('unread-count');
            Route::get('/latest', [NotificationController::class, 'getLatest'])->name('latest');
        });

        Route::get('/Notification', [NotificationController::class, 'index'])->name('Notification');
        Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
        Route::get('/notification-list', [NotificationController::class, 'index'])->name('notification-list');

        // ============================================
        // Settings Route
        // ============================================
        Route::get('/settings', function() { 
            if (view()->exists('Pages.Admin.settings')) {
                return view('Pages.Admin.settings');
            } elseif (view()->exists('Pages.Admin.setting')) {
                return view('Pages.Admin.setting');
            } else {
                abort(404, 'Settings view not found');
            }
        })->name('settings');
    });
    
    // ============================================
    // Complaint Registration (Public - For Users)
    // ============================================
    Route::get('/complaint-registration', [ComplaintController::class, 'create'])->name('complaint.registration');
    Route::post('/complaint-registration', [ComplaintController::class, 'store'])->name('complaint.store');
});

/*
|--------------------------------------------------------------------------
| Main Website Routes (Public - Accessible by everyone)
|--------------------------------------------------------------------------
*/
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/rooms', [PageController::class, 'rooms'])->name('rooms');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/rules', [PageController::class, 'rules'])->name('rules');
Route::get('/booking', [PageController::class, 'booking'])->name('booking');

// ============================================================
// ✅ CONTACT FORM POST ROUTE
// ============================================================
Route::post('/contact', function (Illuminate\Http\Request $request) {
    
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'nullable|string|max:255',
        'message' => 'required|string|min:10',
    ]);

    return back()->with('success', '✅ Your message has been sent successfully!');
    
})->name('contact.submit');