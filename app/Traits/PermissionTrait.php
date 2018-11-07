<?php

namespace App\Traits;

use Auth;
use Carbon\Carbon;
use Closure;

trait PermissionTrait
{
    /**
     * Evalua si el usuario logueado es root o tiene el privilegio de superadmin.
     */
    public function IsRootOrSuper()
    {
        if (Auth::user()->id === 1) {
            return true;
        }
        foreach (Auth::user()->rol as $rol) {
            if ($rol->id == 1) {
                return true;
            }
        }
        return false;
    }

    public function specialAccess()
    {
        foreach (Auth::user()->rol as $rol) {
            if ($rol->special == 'all-access') return 1;
            if ($rol->special == 'no-access') return -1;
        }
        return 0;
    }

    /**
     * Evalua si la la hora esta entre las permitidas.
     */
    public function isHourToAccess()
    {
        $now = Carbon::now();
        foreach (Auth::user()->rol as $rol) {
            if ($rol->from_at == null && $rol->to_at == null) return true;
            $t_init = Carbon::parse($rol->from_at);
            $t_stop = Carbon::parse($rol->to_at);
            if ($now >= $t_init && $now <= $t_stop) return true;
        }
        return false;
    }

    /**
     * Verifica si el usuario tiene ese permiso definido.
     */
    public function canActMod($module, $action)
    {
        return Auth::user()
        ->permisos
        ->where('modulo', '=', $module)
        ->where('accion', '=', $action)
        ->first();
    }

    /**
     * Verifica por completo si tiene acceso el usuario.
     */
    public function iCan($action, $module)
    {
        if (self::IsRootOrSuper()) return true;

        $access = self::specialAccess();
        if ($access == 1) return true;
        if ($access == -1) return false;

        if (! self::isHourToAccess()) return false;

        if (self::canActMod($action, $module)) return true;
    }

}