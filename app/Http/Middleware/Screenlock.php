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
