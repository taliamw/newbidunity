<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Auth facade
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function lockScreen()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        // Update the session table to mark the session as locked
        $sessionId = session()->getId();
        DB::table('sessions')->where('id', $sessionId)->update(['is_locked' => true]);
    
        // Debugging: Check if update was successful
        $session = DB::table('sessions')->where('id', $sessionId)->first();
        dd($session); // This should show the updated session with is_locked = true
    
        Session::put('is_locked', true);
        return view('lockscreen');

    }
    public function unlockScreen(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user(); // Assuming the user is already authenticated and locked the screen

        if (!$user) {
            return redirect()->route('login')->withErrors(['message' => 'You need to log in first.']);
        }

        if (Hash::check($request->password, $user->password)) {
            // Password is correct, unlock the screen
            DB::table('sessions')->where('id', session()->getId())->update(['is_locked' => false]);

            session(['is_locked' => false]);

            return redirect()->route('home'); // Redirect to the desired route

        } else {
            // Password is incorrect, return back with error
            return back()->withErrors(['password' => 'Invalid password']);
        }
    }

    public function logout()
    {
        Auth::logout();
        session()->flush();
        return redirect()->route('login');
    }
}
