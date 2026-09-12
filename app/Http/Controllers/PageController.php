<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function home()
    {
        return view('Pages.home');
    }
    
    public function about()
    {
        return view('Pages.about');
    }
    
    public function services()
    {
        return view('Pages.services');
    }
    
    public function contact()
    {
        return view('Pages.contact');
    }
    
    public function Rooms()
    {
        return view('Pages.Rooms');
    }
  
    public function booking()
    {
        return view('Pages.booking');
    }

    // ===== NAYE METHODS (Explore section ke liye) =====

    public function gallery()
    {
        return view('Pages.Hostel-gallery'); 
    }

    public function faq()
    {
        return view('Pages.Hostel-faqs'); 
    }

    public function rules()
    {
        return view('Pages.Hostel-rules'); 
    }

    // ==================================================

    public function student_records()
    {
        return view('Pages.Admin.student_records');
    }
    
    public function Room_allocation()
    {
        return view('Pages.Admin.Room_allocation');
    }
    
    public function fee_record()
    {
        return view('Pages.Admin.fee_record');
    }
    
    public function staff_records()
    {
        return view('Pages.Admin.staff_records');
    }
    
    public function vistors_records()
    {
        return view('Pages.Admin.vistors_records');
    }
    
    public function Complain_request()
    {
        return view('Pages.Admin.Complain_request');
    }
    
    public function Notification()
    {
        return view('Pages.Admin.Notification');
    }
    
    public function dashboard()
    {
        return view('Pages.Admin.dashboard');
    }
}