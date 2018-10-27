<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licitacion;

class TendersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:tender,index')->only(['index']);
        // $this->middleware('can:tender,store')->only(['store']);
        // $this->middleware('can:tender,show')->only(['show']);
        // $this->middleware('can:tender,update')->only(['update']);
        // $this->middleware('can:tender,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $select = ['id', 'nombre', 'descripcion', 'empresa_id', 'status_id', 'precio_minimo', 'precio_maximo', 'created_at', 'imagen', 'servicio_id', 'tiempo'];
        $licitacion = Licitacion::orderBy(request()->order?:'id', request()->dir?:'ASC')
        ->where('status_id', 1)
        ->search(request()->search)
        ->select($select)
        ->paginate(request()->num?:5);
        $licitacion->each(function ($l) {
            $l->desde = $l->created_at->diffForHumans();
            $l->hasta = $l->created_at->addDays($l->tiempo)->diffForHumans();
            $l->num_ofertas = $l->ofertas->count();
            $servicio = $l->servicio->nombre;
            unset($l->ofertas);
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
