<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        // If already logged in, redirect based on role
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('Pages.Auth.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Check if the user's account is active
            if (!$user->isActive()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact the administrator.',
                ])->onlyInput('email');
            }

            // Update last login timestamp
            $user->updateLastLogin();

            // Clear any "intended" URL so clerks don't get bounced to admin pages
            $request->session()->forget('url.intended');

            // Redirect strictly based on role
            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Redirect user to the correct page based on their role.
     */
    protected function redirectBasedOnRole($user)
    {
        // ✅ Admin → Dashboard
        if ($user->isAdmin()) {
            return redirect()->route('dashboard');
        }

        // ✅ Clerk → Fee Record page
        if ($user->isClerk()) {
            return redirect()->route('fee_record');
        }

        // ✅ Student / Normal User → Home page (no dashboard access)
        return redirect('/');
    }

    // Show signup form
    public function showSignupForm()
    {
        return view('Pages.Auth.signup');
    }

    // Handle signup
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // ✅ Create user with 'user' role (Student / Normal User)
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => User::ROLE_USER,          // ✅ CHANGED: 'user' instead of 'clerk'
            'status'   => User::STATUS_ACTIVE,
        ]);

        Auth::login($user);

        // ✅ Redirect based on role (Student → Home page)
        return $this->redirectBasedOnRole($user)
            ->with('success', 'Account created successfully! Welcome to GCW Hostel.');
    }

    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}