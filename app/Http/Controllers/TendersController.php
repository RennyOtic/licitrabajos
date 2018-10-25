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
        $licitacion = Licitacion::dataForPaginate(['*'], function ($l) {
            $l->desde = $l->created_at->diffForHumans();
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
            'precio_maximo' => 'required|numeric|min:' . $request->precio_minimo,
            'precio_minimo' => 'required|numeric|max:' . $request->precio_maximo,
            'tiempo' => 'required|numeric|min:1|max:10',
        ],[],['descripcion' => 'descripción']);
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
