<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

    <title>Lock Screen</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Add your CSS here -->
    <style>
        /* Add your lock screen CSS styles here */
    </style>
</head>
<body>
    <div id="lock-screen">
        <h1>Screen Locked</h1>
        <form id="unlock-form">
            <input type="password" name="password" placeholder="Enter your password" required>
            <button type="submit">Unlock</button>
        </form>
    </div>

    <!-- Add your JavaScript libraries here, if needed -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#unlock-form').on('submit', function(event) {
                event.preventDefault();
                $.ajax({
                    url: '{{ route('unlock-screen') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        password: $('input[name="password"]').val()
                    },
                    success: function(response) {
                        if (response.status === 'unlocked') {
                            // Redirect to the previous page or any specific route
                            window.location.href = '{{ url()->previous() }}';
                        } else {
                            alert('Invalid password');
                        }
                    },
                    error: function(xhr) {
                        alert('Error unlocking screen. Please try again.');
                    }
                });
            });
        });
    </script>
</body>
</html>
