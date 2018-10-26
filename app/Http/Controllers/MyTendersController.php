<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licitacion;
use App\Models\Servicio;

class MyTendersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:user,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:user,show')->only(['show']);
        $this->middleware('can:user,destroy')->only(['destroy']);
        $this->middleware('can:user,initWithOneUser')->only(['initWithOneUser']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'nombre', 'descripcion', 'empresa_id', 'status_id', 'precio_minimo', 'precio_maximo', 'created_at'];
        $licitacion = Licitacion::orderBy(request()->order?:'id', request()->dir?:'ASC')
        ->where('persona_id', \Auth::user()->id)
        ->search(request()->search)
        ->select($select)
        ->paginate(request()->num?:10);
        $licitacion->each(function ($l) {
            $l->status_id = $l->status->nombre;
            $l->promedio = $l->precio_minimo . '$ - ' . $l->precio_maximo . '$';
            $l->desde = $l->created_at->diffForHumans();
            unset($l->status);
        });
        return $this->dataWithPagination($licitacion);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|min:2|max:350',
            'imagen' => 'nullable|string',
            'nombre' => 'required|string|min:2|max:50',
            'servicio_id' => 'required|numeric',
            'precio_maximo' => 'required|numeric|min:' . $request->precio_minimo,
            'precio_minimo' => 'required|numeric|max:' . $request->precio_maximo,
            'tiempo' => 'required|numeric|min:1|max:10',
        ],[],['descripcion' => 'descripción', 'servicio_id' => 'servicio']);
        $data['persona_id'] = \Auth::user()->id;
        $data['status_id'] = 1;
        $data['slug'] = str_replace(' ', '-', $data['nombre']);
        $slug = Licitacion::where('slug', '=', $data['slug'])->count();
        if ($slug > 0) $data['slug'] .= '-' . $slug;
        Licitacion::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $licitacion = Licitacion::findOrFail($id);
        $servicio = $licitacion->servicio->nombre;
        unset($licitacion->servicio);
        $licitacion->servicio = $servicio;
        return response()->json($licitacion);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|min:2|max:350',
            'imagen' => 'nullable|string',
            'nombre' => 'required|string|min:2|max:50',
            'servicio_id' => 'required|numeric',
            'precio_maximo' => 'required|numeric|min:' . $request->precio_minimo,
            'precio_minimo' => 'required|numeric|max:' . $request->precio_maximo,
            'tiempo' => 'required|numeric|min:1|max:10',
        ],[],['descripcion' => 'descripción', 'servicio_id' => 'servicio']);
        $data['slug'] = str_replace(' ', '-', $data['nombre']);
        $slug = Licitacion::where('slug', '=', $data['slug'])->count();
        if ($slug > 0) $data['slug'] .= '-' . $slug;
        Licitacion::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Licitacion::findOrFail($id)->delete();
    }

    public function dataForRegister()
    {
        $servicio = Servicio::get(['id', 'nombre as text']);
        return response()->json(compact('servicio'));
    }
}
