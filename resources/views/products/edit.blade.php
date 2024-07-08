@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Listing</h1>
    <form action="{{ route('admin.products.update', $listing->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $listing->name }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" required>{{ $listing->description }}</textarea>
        </div>

        <!-- Add more fields as needed -->

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
