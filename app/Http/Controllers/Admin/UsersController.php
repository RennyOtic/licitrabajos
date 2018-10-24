<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ { UserStoreRequest, UserUpdateRequest, ChangePasswordRequest };
use App\Usuario;
use App\Models\Permisologia\Rol;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:user,show')->only(['show']);
        $this->middleware('can:user,destroy')->only(['destroy']);
        $this->middleware('can:user,initWithOneUser')->only(['initWithOneUser']);
    }

    /**
     * Muestra una lista de recursos en json o la vista.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = Usuario::dataForPaginate();
        $users->each(function ($u) {
            $rol = '';
            foreach ($u->rol as $r) {
                $rol .= '<span class="badge">' . $r->nombre . '</span>';
            }
            unset($u->rol);
            $u->rol = $rol;
            $u->fullName = $u->fullName();
        });
        return $this->dataWithPagination($users);
    }

    /**
     * Almacena un recurso recién creado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {
        $data = $request->validated();
        $user = new Usuario($data);
        $user->password = bcrypt($data['password']);
        $user->save();
        $user->rol()->attach($request->roles);
        $user->assignPermissionsOneUser($request->roles);
    }

    /**
     * Mostrar el recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Usuario::findOrFail($id);
        $user->fullName = $user->fullName();
        $rol = $user->rol->pluck('nombre')->toArray();
        unset($user->rol);
        $user->rol = $rol;
        return response()->json($user);
    }

    /**
     * Actualiza el recurso especificado en el almacenamiento.
     *
     * @param  \App\Http\Requests\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if($request->id == 1) return response(['msg' => 'Error al modificar usuario'], 401);

        $data = $request->validated();

        if(!empty($request->password)){
            $data['password'] = bcrypt($this->validate($request, [
                'password' => 'string|min:6|confirmed'
            ])['password']);
        }

        $user = Usuario::findOrFail($id)->fill($data);
        $user->update_pivot($request->roles, 'rol', 'rol_id');
        $user->assignPermissionsOneUser($request->roles);

        return response()->json($user->save());
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id === 1) return response(['msg' => 'Error al modificar usuario'], 422);
        $user = Usuario::findOrFail($id)->delete();
    }

    /**
     * se inicia la session con un recurso especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function initWithOneUser($id)
    {
        if ($id == 1 || \Auth::user()->id !== 1) return \Auth::logout();
        \Auth::loginUsingId($id);
        return redirect()->to('/');
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $roles = Rol::get(['id', 'nombre as text']);
        return response()->json(compact(['roles']));
    }

}
