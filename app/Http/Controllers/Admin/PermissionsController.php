<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Permisologia\Permiso;
use App\Http\Requests\PermissionUpdateRequest;

class PermissionsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:permission,index')->only(['index']);
        $this->middleware('can:permission,show')->only(['show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permiso::withTrashed()
        ->orderBy(request()->order?:'id', request()->dir?:'DESC')
        ->search(request()->search)
        ->paginate(request()->num?:10);

        $permissions->each(function ($p) {
            $p->activo = ($p->deleted_at) ? 
            '<i class="glyphicon glyphicon-unchecked"></i>' : 
            '<i class="glyphicon glyphicon-check"></i>';
        });
        return $this->dataWithPagination($permissions);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permiso::withTrashed()->findOrFail($id);
        $permission->activo = ($permission->deleted_at) ? true : false;
        return response()->json($permission);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PermissionUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionUpdateRequest $request, $id)
    {
        $permission = Permiso::withTrashed()->findOrFail($id);
        $permission->update($request->validated());
        ($request->activo) ? $permission->delete() : $permission->restore();
    }
}
