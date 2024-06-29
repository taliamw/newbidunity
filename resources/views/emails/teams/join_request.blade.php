@component('mail::message')
# Join Team Request

{{ $user->name }} ({{ $user->email }}) has requested to join your team "{{ $team->name }}".

@component('mail::button', ['url' => route('teams.admit', ['team' => $team->id, 'user' => $user->id])])
Admit
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
