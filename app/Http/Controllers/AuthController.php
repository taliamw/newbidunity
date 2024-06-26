<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
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
            session(['screen_locked' => false]);

            return  redirect()->route('home'); // Redirect to the desired route
        } else {
            // Password is incorrect, return back with error
            return back()->withErrors(['password' => 'Invalid password']);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
