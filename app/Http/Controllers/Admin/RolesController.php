<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permisologia\ { Rol, Permiso };
use App\Http\Requests\ { RolStoreRequest, RolUpdateRequest };

class RolesController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:rol,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:rol,show')->only(['show']);
        $this->middleware('can:rol,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Rol::dataForPaginate(['*'], function ($r) {
            $r->especial = ($r->especial) ? 
            '<i class="glyphicon glyphicon-check"></i>' : 
            '<i class="glyphicon glyphicon-unchecked"></i>';
            $r->hours = 'Siempre';
            if ($r->from_at && $r->to_at) {
                $r->hours = $r->from_at . ' - ' . $r->to_at;
            }
        });
        return $this->dataWithPagination($roles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\RolStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RolStoreRequest $request)
    {
        $rol = Rol::create($request->validated());
        if (!$request->especial) {
            $rol->update_pivot($request->permisos, 'permisos', 'permiso_id')
            ->assignPermissionsAllUser();
        }
        return response()->json($rol);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $rol = Rol::findOrFail($id);
        $permisos = $rol->permisos->pluck('id');
        unset($rol->permisos);
        $rol->permisos = $permisos;
        return response()->json($rol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\RolUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RolUpdateRequest $request, $id)
    {
        if($id == 1) return response(['msg' => 'Error al modificar Rol'], 401);
        $rol = Rol::findOrFail($id)->fill($request->validated());
        if(!$request->especial) {
            $rol->update_pivot($request->permisos, 'permisos', 'id')
            ->assignPermissionsAllUser() ;
        } else {
            $rol->permisos()->detach($request->permisos);
        }
        return response()->json($rol->save());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($id == 1) return response(['msg' => 'Error al modificar usuario'], 422);
        $rol = Rol::findOrFail($id);
        $rol->usuarios()->detach($rol->usuarios->pluck('id'));
        $rol->delete();
    }

    /**
     * Retorna los datos que se usaran para crear y editar.
     *
     * @return \Illuminate\Http\Response
     */
    public function dataForRegister()
    {
        $permissions = Permiso::get(['id', 'nombre', 'modulo']);
        return response()->json(compact('permissions'));
    }

}
