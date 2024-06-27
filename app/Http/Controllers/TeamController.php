<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    public function show(Team $team)
    {
        return view('teams.show', compact('team'));
    }

    public function create()
    {
        $user = Auth::user(); // Assuming you are getting the authenticated user
        return view('teams.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Assuming the authenticated user is the creator of the team
        $team = new Team;
        $team->name = $request->name;
        $team->user_id = auth()->id(); // Assuming the user_id field in your teams table
        $team->save();

        $team->users()->attach(auth()->id()); //// Attach the current user to the team
         // Update the current_team_id for the authenticated user if it's currently null
        $user = auth()->user();
        if ($user->current_team_id === null) {
            $user->current_team_id = $team->id;
            $user->save();
        }

        return redirect()->route('teams.show', $team->id);
    }

}
