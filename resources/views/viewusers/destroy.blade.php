<!-- Delete confirmation -->
<h1>Delete User</h1>
<p>Are you sure you want to delete this user?</p>
<p>Name: {{ $user->name }}</p>
<p>Email: {{ $user->email }}</p>
<form action="{{ route('viewusers.destroy', $user->id) }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">Confirm Delete</button>
</form>