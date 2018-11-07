<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Licitacion;

class TendersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:tender,index')->only(['index']);
        $this->middleware('can:tender,store')->only(['store']);
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
        ->where('empresa_id', null)
        ->whereIn('servicio_id', \Auth::user()->servicios->pluck('id'))
        ->search(request()->search)
        ->select($select)
        ->paginate(request()->num?:5);
        $licitacion->each(function ($l) {
            $l->imagen = $l->img();
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
        $data = $request->validate([
            'comentario' => 'required|string',
            'evaluacion' => 'required|numeric|min:1|max:5',
            'id' => 'required|numeric'
        ]);
        Licitacion::findOrFail($request->id)
        ->update($data);
    }

    public function image(Request $request)
    {
        if ($request->hasFile('img')) {
            return $url = $request->img->store('/tenders');
        }
    }
}
