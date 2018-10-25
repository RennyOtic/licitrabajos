<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Requests\ { ChangePasswordRequest, UpdatePerfilUserRequest };
use App\Models\Servicio;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = \Auth::user();
        $user->fullName = $user->fullName();
        $user->logoPath = $user->getLogoPath();
        $user->roles;
        $servicios = $user->servicios->pluck('nombre')->toArray();
        unset($user->servicios);
        $user->servicios = $servicios;
        $servicio = Servicio::get(['id', 'nombre as text']);
        return response()->json(compact('user', 'servicio'));
    }

    /**
     * Edita datos del usuario.
     *
     * @param  \App\Http\Requests\UpdatePerfilUserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editUser(UpdatePerfilUserRequest $request){
        if ($request->servicios) {
            \Auth::user()->update_pivot(explode(',', $request->servicios), 'servicios', 'servicio_id');
        }
        $user = \Auth::user()->update($request->validated());
        if ($request->hasFile('image')) {
            $extension = $request->image->getClientOriginalExtension();
            $request->image->storeAs('users/image', \Auth::user()->id.'.'.$extension);
        }
    }

    /**
     * Edita el password del usuario logueado.
     *
     * @param  \App\Http\Requests\ChangePasswordRequest $request
     * @return \Illuminate\Http\Response
     */
    public function editPassword(ChangePasswordRequest $request){
        $user = \Auth::user()->fill([
            'password' => bcrypt($request->password)
        ])->save();
        return response()->json($user);
    }

    /**
     * Retorna los datos de los modulos.
     * Permite al usuario cambiarse de modulo.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    // public function changeModule(Request $request)
    // {
        // if ($request->method() == 'POST') {
        //     $user = User::findOrFail(Auth::user()->id)->fill([
        //         'module_id' => $request->key
        //     ])->save();
        //     return response()->json($user);
        // } elseif ($request->method() == 'GET') {
        //     $module  = Auth::user()->module()->pluck('module', 'id')->toArray();
        //     $modules = (Auth::user()->iCan('changeModule', 'module')) ? 
        //     array_diff(Module::all()->pluck('module', 'id')->toArray(), $module) : null;

        //     return response()->json(compact('modules', 'module'));
        // }
    // }
}
