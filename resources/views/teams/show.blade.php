<!-- resources/views/team/contributions.blade.php -->
<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-custom-logo />
        </x-slot>

        <div class="mb-4">
        {{-- Display Success Message --}}
@if(session('success'))
    <div class="alert alert-success mt-3">{{ session('success') }}</div>
@endif


            {{-- Display Error Message --}}
            @if(session('error'))
            <div class="alert alert-danger mt-3">{{ session('error') }}</div>
            @endif
            <h1 class="text-2xl font-bold">{{ $team->name }}</h1>
            <p class="text-gray-600 mt-2">Created: {{ $team->created_at->diffForHumans() }}</p>

            <div class="mt-4">
                <h3 class="text-lg font-semibold">Owner</h3>
                <p>{{ $team->owner->name }}</p>
            </div>

            <div class="mt-4">
                <h3 class="text-lg font-semibold">Members</h3>
                <ul>
                    @foreach ($team->users as $user)
                        <li>{{ $user->name }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-4">
                <h3 class="text-lg font-semibold">Contributions</h3>
                <div style="overflow-x: auto;">
                <table class="table-auto w-full border-collapse border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2">User</th>
                            <th class="px-4 py-2">Amount</th>
                            <th class="px-4 py-2">Percentage</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userContributions as $userContribution)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2">{{ $userContribution['name'] }}</td>
                                <td class="border border-gray-200 px-4 py-2">Ksh{{ number_format($userContribution['amount'], 2) }}</td>
                                <td class="border border-gray-200 px-4 py-2">{{ number_format($userContribution['percentage'], 2) }}%</td>
                                <td class="border border-gray-200 px-4 py-2">
                                @auth
                                            @if(auth()->id() === $userContribution['user_id'])
                                                <form action="{{ route('contributions.subtract', ['contribution' => $userContribution['id']]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-group mb-2">
                                                        <label for="subtract_amount" class="block text-sm font-medium text-gray-700">Subtract Amount</label>
                                                        <input type="number" step="0.01" name="amount" id="subtract_amount" class="mt-1 block w-full" required>
                                                    </div>
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">
                                                        Subtract Contribution
                                                    </button>
                                                </form>
                                            @endif
                                        @endauth

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
</div>
                <h3 class="mt-4">Total Contributions: Ksh {{ number_format($totalContributions, 2) }}</h3>
            </div>

            <div class="mt-4">
                <h3 class="text-lg font-semibold">Contribute to the Team</h3>
                <form action="{{ route('contributions.store') }}" method="POST" class="mt-2">
                    @csrf
                    <input type="hidden" name="team_id" value="{{ $team->id }}">
                    <div class="form-group mb-4">
                        <label for="amount" class="block text-sm font-medium text-gray-700">Contribution Amount</label>
                        <input type="number" step="0.01" name="amount" id="amount" maxlength= "12" class="mt-1 block w-full">
                    </div>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Contribute
                    </button>

                    @php
                     $contributionAmount = $userContribution['amount'] ?? 0;
                     @endphp
                     <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <a href="{{ route('payment', ['amount' => $contributionAmount]) }}">Make payment</a>
                    </button>
                    @if($contributionAmount == 0)
                    <p>Please set your contribution amount before making a payment.</p>
                    @endif
                    <br><br>

                    
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <a href="{{ route('allocation.report.pdf', ['team' => $team]) }}">Generate Allocation Report</a>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('dashboard') }}" class="ml-4 text-sm text-gray-600 underline">Back to Dashboard</a>
        </div>
    </x-authentication-card>
</x-guest-layout>
