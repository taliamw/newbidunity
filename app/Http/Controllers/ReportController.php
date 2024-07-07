<?php
namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Contribution;
use Illuminate\Http\Request;
use PDF;

class ReportController extends Controller
{
    /**
     * Generate allocation report for a specific team.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function generate(Team $team)
    {
        // Retrieve user contributions for the team
        $userContributions = Contribution::with('user')
            ->where('team_id', $team->id)
            ->get();

        // Calculate total contributions
        $totalContributions = $userContributions->sum('amount');

        // Calculate percentages
        $userContributions = $userContributions->map(function ($contribution) use ($totalContributions) {
            $contribution->percentage = $totalContributions > 0 ? ($contribution->amount / $totalContributions) * 100 : 0;
            return $contribution;
        });

        // Load HTML content of the report view
        $html = view('reports.allocation', compact('team', 'userContributions', 'totalContributions'))->render();

        // Generate PDF
        $pdf = PDF::loadHtml($html);

        // Set options for PDF if needed
        $pdf->setPaper('A4', 'portrait');

        // Output PDF
        return $pdf->download('allocation_report.pdf');
    }
}
