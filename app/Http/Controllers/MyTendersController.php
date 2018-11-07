<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Licitacion, Servicio, Chat };

class MyTendersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:mytender,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:mytender,store')->only(['store']);
        $this->middleware('can:mytender,show')->only(['show']);
        $this->middleware('can:mytender,update')->only(['update']);
        $this->middleware('can:mytender,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'nombre', 'descripcion', 'empresa_id', 'status_id', 'evaluacion', 'created_at', 'persona_id'];
        $licitacion = Licitacion::orderBy(request()->order?:'id', request()->dir?:'DESC')
        ->where('persona_id', \Auth::user()->id)
        ->search(request()->search)
        ->select($select)
        ->paginate(request()->num?:10);
        $licitacion->each(function ($l) {
            $l->propuestas = $l->ofertas->count();
            $l->status_id = $l->status->nombre;

            $chat = Chat::where('licitacion_id', $l->id)
            ->where('persona_id', $l->persona_id)
            ->where('empresa_id', $l->empresa_id)
            ->first();
            $l->empresa_id = optional($l->empresa)->fullName();
            if ($chat) $l->empresa_id = '<a href="/chat/' . $chat->id . '">' . $l->empresa_id . '</a>';
            if ($l->empresa_id && $l->evaluacion == '') {
                $l->evaluacion = '<a href="/licitacion/' . $l->id . '">Evaluar</a>';
            } elseif ($l->evaluacion == null) {
                $l->evaluacion = 'No Evaluado';
            } else {
                $l->evaluacion = 'No Evaluado';
            }
            $l->desde = $l->created_at->diffForHumans();
            unset($l->status, $l->empresa, $l->ofertas);
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
        $licitacion->empresa;
        $licitacion->ev = ($licitacion->evaluacion) ? false : true;
        if ($licitacion->empresa != null) $licitacion->empresa->fullName = $licitacion->empresa->fullName();
        $offer = $licitacion->ofertas->where('usuario_id', \Auth::user()->id)->first();
        $licitacion->offer = optional($offer)->id;
        $licitacion->imagen = $licitacion->img();
        $licitacion->propuesta = optional($offer)->propuesta;
        unset($licitacion->servicio, $licitacion->ofertas);
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
