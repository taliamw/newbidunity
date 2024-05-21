<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Screen</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded shadow">
        <h2 class="mb-6 text-center text-2xl font-semibold">Unlock Your Screen</h2>
        <p>This will take you home to sign in again</p>
        <form method="POST" action="{{ route('unlock-screen') }}">
            @csrf
           <!--<div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>-->
            <a href="/home"><h2>Unlock</h2></a> 
        </form>
    </div>
</body>
</html>