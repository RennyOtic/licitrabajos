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
        $rol = $user->rol->first()->nombre;
        $user->miembro = $user->created_at->diffForHumans();
        $servicios = $user->servicios->pluck('nombre')->toArray();
        $user->projects_p = $user->licitaciones->count();
        $user->projects_r = $user->licitaciones2->count();
        unset($user->servicios, $user->licitaciones, $user->licitaciones2, $user->rol);
        $user->rol = $rol;
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
}
