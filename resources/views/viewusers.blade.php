@extends('layout')

@section('content')
    <!-- ======= Viewusers Section ======= -->
    <br><br><br><br><br>
    <h1>User Details</h1>

    <!-- Create Button -->

    <table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <!-- Edit Button -->
                    <a href="{{ route('viewusers.edit', $user->id) }}" class="btn btn-primary">Edit</a>

                    <!-- Delete Button -->
                    <form action="{{ route('viewusers.destroy', $user->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<a href="{{ route('export.table.pdf') }}" class="btn btn-primary">Download PDF</a>

@endsection