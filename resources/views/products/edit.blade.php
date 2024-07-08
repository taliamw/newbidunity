@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Listing</h1>
    <form action="{{ route('admin.products.update', $listing->id) }}" method="POST" enctype="multipart/form-data">
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

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" name="price" class="form-control" value="{{ $listing->price }}" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control">
            @if ($listing->image)
                <div>
                    <img src="{{ asset('storage/' . $listing->image) }}" alt="Product Image" style="max-width: 200px; margin-top: 10px;">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-color: #007bff;">Update</button>
    </form>
</div>
@endsection
