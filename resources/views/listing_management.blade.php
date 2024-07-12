@extends('admin.layout')
<br>
@section('content')
<div class="row">
    <div class="container mt-5">
    <br><br><br><br><br>
    <h1>Pending Listings</h1>
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Documents</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pendingProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->status }}</td>
                            <td>
                        @foreach ($product->documents as $document)
                            <a href="{{ asset('storage/' . $document->path) }}" target="_blank">Download</a><br>
                        @endforeach
                    </td>
                            <td>
                                <!-- Approve Form -->
                                <form method="POST" action="{{ route('admin.listings.approve', $product->id) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-success" style="background-color: #28a745; border-color: #28a745;">Approve</button>
                                </form>

                                <!-- Reject Form -->
                                <form id="rejectionForm" method="POST" action="{{ route('admin.listings.reject', $product->id) }}" class="d-inline">
    @csrf
    @method('PUT')
    <input type="hidden" name="reason" id="rejectReason">
    <button type="button" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545;" onclick="showRejectPopup()">Reject</button>
</form>

<script>
    function showRejectPopup() {
        var reason = prompt("Enter rejection reason:");
        if (reason) {
            $('#rejectReason').val(reason);
            $('#rejectionForm').submit();
        }
    }
</script>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br><br><br><br>

        </div>
    </div>
    <!-- Approved Listings -->
    <h2>Approved Listings</h2>

    <div class="container mt-5">
        <!-- Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($approvedProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->auction_status }}</td>
                            <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="background-color: #dc3545; border-color: #dc3545;" onclick="return confirm('Are you sure you want to delete this listing?')">Delete</button>
                    </form>
                </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br><br>
        </div>
    </div>
    <!-- Rejected Listings -->
    <h1>Rejected Listings</h1>
    <div class="container mt-5">
        <!-- Table -->
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($rejectedProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br><br><br><br><br>

        </div>
    </div>
@endsection
