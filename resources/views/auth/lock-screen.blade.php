<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lock Screen</title>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Function to redirect to the lock screen
            function redirectToLockScreen() {
                var currentUrl = window.location.href;
                if (!currentUrl.includes('lockscreen=true')) {
                    var lockScreenUrl = currentUrl.split('?')[0] + '?lockscreen=true';
                    window.location.replace(lockScreenUrl);
                }
            }

            // Function to push a dummy history state
            function pushHistoryState() {
                history.pushState(null, null, location.href);
            }

            // Function to prevent back navigation
            function preventBack(event) {
                pushHistoryState();
                event.preventDefault();
            }

            // Check if the current page is the lock screen
            function isLockScreen() {
                return location.search.includes('lockscreen=true');
            }

            // Redirect to lock screen if necessary
            if (!isLockScreen()) {
                redirectToLockScreen();
            }

            // If on the lock screen, prevent back navigation
            if (isLockScreen()) {
                // Push a dummy state to history to trap the user on the lock screen
                pushHistoryState();
                window.addEventListener('popstate', preventBack);
                window.addEventListener('beforeunload', function (event) {
                    // Ensure history state is maintained on refresh
                    pushHistoryState();
                });
            }
        });
    </script>
</head>
<?php
?>
<body class="h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded shadow" id="lockScreen">
        <h2 class="mb-6 text-center text-2xl font-semibold">Unlock Your Screen</h2>
        <p>This will take you home to sign in again</p>
        <form method="POST" action="{{ route('unlock-screen') }}">
            @csrf
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @error('password')
                <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Unlock
            </button>
        </form>
    </div>
</body>
</html>