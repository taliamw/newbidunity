<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
<script>
    let inactivityTime = function () {
        let time;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;  // catches touchscreen presses
        window.ontouchstart = resetTimer; // catches touch screen swipes
        window.onclick = resetTimer;      // catches touchpad clicks
        window.onkeydown = resetTimer;   
        window.addEventListener('scroll', resetTimer, true); // improved; see comments

        function lockScreen() {
            axios.post('/lock-screen').then(response => {
                sessionStorage.setItem('screen_locked', 'true');
                window.location.href = '/lock-screen';
            });
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(lockScreen, 600000);  // 10 minutes
        }
    };

    inactivityTime();
</script>
<script>
    let inactivityTime = function () {
        let time;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;  // catches touchscreen presses
        window.ontouchstart = resetTimer; // catches touch screen swipes
        window.onclick = resetTimer;      // catches touchpad clicks
        window.onkeydown = resetTimer;   
        window.addEventListener('scroll', resetTimer, true); // improved; see comments

        function lockScreen() {
            axios.post('/lock-screen').then(response => {
                sessionStorage.setItem('screen_locked', 'true');
                window.location.href = '/lock-screen';
            });
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(lockScreen, 600000);  // 10 minutes
        }
    };

    inactivityTime();
</script>
<script>
    let inactivityTime = function () {
        let time;
        window.onload = resetTimer;
        window.onmousemove = resetTimer;
        window.onmousedown = resetTimer;  // catches touchscreen presses
        window.ontouchstart = resetTimer; // catches touch screen swipes
        window.onclick = resetTimer;      // catches touchpad clicks
        window.onkeydown = resetTimer;   
        window.addEventListener('scroll', resetTimer, true); // improved; see comments

        function lockScreen() {
            axios.post('/lock-screen').then(response => {
                sessionStorage.setItem('screen_locked', 'true');
                window.location.href = '/lock-screen';
            });
        }

        function resetTimer() {
            clearTimeout(time);
            time = setTimeout(lockScreen, 600000);  // 10 minutes
        }
    };

    inactivityTime();
</script>
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScreenLock
{
    public function handle(Request $request, Closure $next)
    {
        if (session('screen_locked', false) && !$request->is('lock-screen') && !$request->is('unlock-screen')) {
            return redirect()->route('lock-screen');
        }
        return $next($request);
    }
}
