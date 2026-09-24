<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Student;
use App\Models\Staff;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRooms     = Room::count();
        $totalStudents  = Student::count();
        $totalStaff     = Staff::count();
        $allocatedRooms = Room::where('status', 'allocated')->count(); // agar column ka naam different hai toh adjust karein
        $emptyRooms     = Room::where('status', 'empty')->count();

        return view('Pages.Admin.dashboard', compact(
            'totalRooms',
            'totalStudents',
            'totalStaff',
            'allocatedRooms',
            'emptyRooms'
        ));
    }
}