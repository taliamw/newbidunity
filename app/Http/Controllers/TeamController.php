<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\JoinTeamRequest;

class TeamController extends Controller
{
    public function show(Team $team)
{
    // Get contributions with users
    $contributions = $team->contributions()->with('user')->get();

    // Aggregate contributions by user
    $userContributions = [];
    foreach ($contributions as $contribution) {
        if (isset($userContributions[$contribution->user->id])) {
            $userContributions[$contribution->user->id]['amount'] += $contribution->amount;
        } else {
            $userContributions[$contribution->user->id] = [
                'name' => $contribution->user->name,
                'amount' => $contribution->amount
            ];
        }
    }

    // Calculate total contributions
    $totalContributions = array_sum(array_column($userContributions, 'amount'));

    // Calculate ownership percentage for each user
    foreach ($userContributions as &$userContribution) {
        $userContribution['percentage'] = $totalContributions > 0 ? ($userContribution['amount'] / $totalContributions) * 100 : 0;
    }

    return view('teams.show', compact('team', 'userContributions', 'totalContributions'));
}

    

    public function join()
    {    
        return view('teams.join');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:teams',
        ]);

        try {
            $team = new Team;
            $team->name = $request->name;
            $team->user_id = auth()->id(); // Assuming the user_id field in your teams table
            $team->save();
    
            // Attach the current user to the team
            $team->users()->attach(auth()->id());
    
            // Update the current_team_id for the authenticated user if it's currently null
            $user = auth()->user();
            if ($user->current_team_id === null) {
                $user->current_team_id = $team->id;
                $user->save();
            }
    
            return redirect()->route('teams.show', $team->id);
        } catch (QueryException $e) {
            // Handle the specific MySQL integrity constraint violation error
            if ($e->errorInfo[1] === 1062) {
                return back()->withErrors(['name' => 'The team name is already taken. Please choose a different name.']);
            }
            
            // Handle other query exceptions or rethrow if needed
            throw $e;
        }

        return redirect()->route('teams.show', $team->id);
    }




    public function sendJoinRequest(Request $request)
    {
        $request->validate([
            'team_name' => 'required|string|max:255',
        ]);

        $team = Team::where('name', $request->team_name)->first();

        if (!$team) {
            return back()->withErrors(['team_name' => 'Team not found.']);
        }
        
        // Check if the user is already a member of the team
    if ($team->users()->where('user_id', auth()->id())->exists()) {
        return back()->withErrors(['team_id' => 'You are already a member of this team.']);
    }

        $owner = $team->owner;

        Mail::to($owner->email)->send(new JoinTeamRequest(auth()->user(), $team));

        return redirect()->route('dashboard')->with('status', 'Join request sent.');
    }

    public function admit(Team $team, User $user)
    {
        // Logic to admit the user into the team
        $team->users()->attach($user->id);
        $user->current_team_id = $team->id;
        $user->save();

        return redirect()->route('teams.show', $team->id);
    }
}
