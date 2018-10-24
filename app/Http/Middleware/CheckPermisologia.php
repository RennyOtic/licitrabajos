<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckPermisologia
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module = null, $action = null)
    {
        $user = Auth::user();
        if ($user->IsRootOrSuper()) return $next($request);

        foreach ($user->roles as $rol) {
            if ($rol->special == 'all-access') return $next($request);
            // if ($rol->special == 'no-access') return redirect()->to('logout');
            if ($rol->special == 'no-access') return Auth::logout();
        }

        if (! $user->isHourToAccess()) return abort(401, 'Uso de la aplicación fuera del rango horario.');

        if ($user->canActMod($module, $action)) return $next($request);

        return Auth::logout();

        // return redirect()->to('/');
        // return abort(401, 'No posee acceso.');
        // return response('Unauthorized.', 401);
    }
}
