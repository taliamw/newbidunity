<?php

namespace App\Http\Controllers;
use App\Models\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        // Authorization moved to specific method
    }

    public function index()
    {
$this->authorize("viewAny", User::class);
$users = User::all();
        return view('admin.adminhome', );
    }
    public function viewUsers()
    {
        // Fetch users data and display in 'viewusers.blade.php'
        $users = User::all();
        return view('viewusers', compact('users'));
    }
    // Show the form for creating a new user
    /*public function create()
    {
        return view('');
    }*/

    // Store a newly created user in the database
   // App\Http\Controllers\UserController.php

   public function store(Request $request)
   {
       $validatedData = $request->validate([
           'name' => 'required|string|max:255',
           'email' => 'required|email|unique:users,email',
       ]);
   
       $isAdmin = in_array($request->input('email'), ['moneyass358@gmail.com', 'admin2@example.com']);
   
       $user = User::create(array_merge($validatedData, ['role' => $isAdmin ? 'admin' : 'user']));
   
       if ($isAdmin) {
           // Log in the admin user
           Auth::login($user);
           return redirect()->route('admin.home'); // Redirect admins to the admin dashboard
       } else {
           return redirect()->route('viewusers')
               ->with('success', 'User created successfully'); // Default redirection for other users
       }
   }
   

    

    // Display the specified user
    public function show(User $user)
    {
        return view('admin.showuser', compact('user'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        return view('admin.edituser', compact('user'));
    }

    // Update the specified user in the database
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

    // Remove the specified user from the database
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('viewusers')
            ->with('success', 'User deleted successfully');
    }
public function loadChartJsPage(){
    return view("admin.chartjs-page");
}


public function add_admin(){
    return view("admin.add_admin");
}




public function fetchUserRoleStatistics()
{
    $adminCount = User::where('role', 'admin')->count();
    $userCount = User::where('role', 'user')->count();

    return response()->json([
        'adminCount' => $adminCount,
        'userCount' => $userCount,
    ]);
}
}