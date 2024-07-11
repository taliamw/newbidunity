<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bid;
use App\Models\NewProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $this->authorize("viewAny", User::class);

        // Fetch users data and display in 'viewusers.blade.php'
        $users = User::all();
        $users = User::with('registeredBy')->get();
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
   
         // Check if the request is for admin registration
         $role = $request->input('role') == 'admin' ? 'admin' : 'user';

         $registeredBy = Auth::id();

         // Create the user with the appropriate role
         User::create(array_merge($validatedData, [
            'role' => $role,
            'registered_by' => $registeredBy,
        ]));
 
         return redirect()->route('viewusers')
             ->with('success', 'User created successfully');
   }
   

    

    // Display the specified user
    public function show(User $user)
    {
        $this->authorize("viewAny", User::class);

        
        return view('admin.showuser', compact('user'));
    }

    // Show the form for editing the specified user
    public function edit(User $user)
    {
        $this->authorize("viewAny", User::class);

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
        $this->authorize("viewAny", User::class);

        $user->delete();

        return redirect()->route('viewusers')
            ->with('success', 'User deleted successfully');
    }

public function loadChartJsPage(){
    $this->authorize("viewAny", User::class);

    return view("admin.chartjs-page");
}


public function add_admin(){
    $this->authorize("viewAny", User::class);

    return view("admin.add_admin");
}


public function analytics() {
    $bidsPerDay = Bid::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
                      ->groupBy('date')
                      ->get();

    $revenueOverTime = Bid::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
                          ->groupBy('date')
                          ->get();

    $topBiddingUsers = User::withCount('bids')
                           ->orderBy('bids_count', 'desc')
                           ->take(10)
                           ->get();

    $topBiddedProducts = NewProduct::withCount('bids')
                                ->orderBy('bids_count', 'desc')
                                ->take(10)
                                ->get();

    return view('admin.analytics', compact('bidsPerDay', 'revenueOverTime', 'topBiddingUsers', 'topBiddedProducts'));
}

}