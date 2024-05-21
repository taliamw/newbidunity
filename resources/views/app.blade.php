<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Head content... -->
</head>
<body>
    <div class="container">
        @yield('content')
    </div>
</body>
</html>
