@props(['team', 'component' => 'dropdown-link'])

<form method="POST" action="{{ route('current-team.update') }}" x-data>
    @csrf
    @method('PUT')

    <!-- Hidden input to send team ID -->
    <input type="hidden" name="team_id" value="{{ $team->id }}">

    <x-{{ $component }} href="#" @click.prevent="$root.submit();">
        {{ $team->name }}
    </x-{{ $component }}>
</form>
