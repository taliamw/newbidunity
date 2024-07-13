<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contribution;
use App\Models\Team;

class ContributionController extends Controller
{

    public function create()
    {
        $user = auth(); // Assuming you are getting the authenticated user
        return view('teams.create', compact('user'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'team_id' => 'required|exists:teams,id',
            'amount' => 'required|numeric|min:0.01',
        ]);

        Contribution::create([
            'team_id' => $request->team_id,
            'user_id' => auth()->id(),
            'amount' => $request->amount,
        ]);

        return redirect()->route('teams.show', $request->team_id)->with('success', 'Contribution added successfully.');
    }

    public function subtractContribution(Request $request, Contribution $contribution)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:' . $contribution->amount,
        ]);

        $contribution->amount -= $request->amount;
        $contribution->save();

        return redirect()->back()->with('success', 'Contribution amount subtracted successfully.');
    }
    
}
