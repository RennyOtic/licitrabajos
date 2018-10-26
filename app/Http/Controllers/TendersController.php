<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licitacion;

class TendersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // request()->num = 5;
        $select = ['id', 'nombre', 'descripcion', 'empresa_id', 'status_id', 'precio_minimo', 'precio_maximo', 'created_at', 'imagen', 'servicio_id', 'tiempo'];
        $licitacion = Licitacion::dataForPaginate($select, function ($l) {
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
