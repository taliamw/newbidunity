<!DOCTYPE html>
<html>
<head>
    <title>Allocation Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Allocation Report for {{ $team->name }}</h1>
    <p>Created: {{ $team->created_at->diffForHumans() }}</p>

    <h3>Owner</h3>
    <p>{{ $team->owner->name }}</p>

    <h3>Members</h3>
    <ul>
        @foreach ($team->users as $user)
            <li>{{ $user->name }}</li>
        @endforeach
    </ul>

    <h3>Contributions</h3>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Amount</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($userContributions as $contribution)
                <tr>
                    <td>{{ $contribution->user->name }}</td>
                    <td>${{ number_format($contribution->amount, 2) }}</td>
                    <td>{{ number_format($contribution->percentage, 2) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <h3>Total Contributions: ${{ number_format($totalContributions, 2) }}</h3>
</body>
</html>
