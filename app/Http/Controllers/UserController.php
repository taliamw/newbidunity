<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // No constructor needed for authorization in this example

    public function index()
    {
        $this->authorize("viewAny", User::class);
        $users = User::all();
        return view('admin.adminhome', compact('users'));
    }

    public function viewUsers()
    {
        $users = User::all();
        return view('viewusers', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            // Add more validation rules as needed
        ]);

        User::create($validatedData);

        return redirect()->route('viewusers.index')
            ->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('admin.showuser', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.edituser', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // Add more validation rules as needed
        ]);

        $user->update($validatedData);

        return redirect()->route('viewusers.index')
            ->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('viewusers.index')
            ->with('success', 'User deleted successfully');
    }

    public function loadChartJsPage()
    {
        return view('chartjs-page');
    }

    public function lockScreen()
    {
        session(['paused' => true]);
        return view('auth.lock');
    }

    public function unlockScreen(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = Auth::user();
        if (Hash::check($request->password, $user->password)) {
            session()->forget('paused');
            return redirect()->route('home');
        }

        return back()->withErrors(['password' => 'Incorrect password.']);
    }
}
