@extends('layout')

@section('content')

<br><br><br><br><br>
<div class="container mt-5">

<h2>Create an admin</h2><br>
<!-- Create User Form -->
<form action="{{ route('viewusers.store') }}" method="POST">
    @csrf
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    <br><br>
    <input type="hidden" name="role" value="admin">
    <br>
    <button type="submit" class="btn btn-primary">Create Admin</button><br>
</form>
</div>
@endsection