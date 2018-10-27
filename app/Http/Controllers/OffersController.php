<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Oferta,Licitacion};

class OffersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:offer,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:offer,store')->only(['store']);
        $this->middleware('can:offer,show')->only(['show']);
        $this->middleware('can:offer,update')->only(['update']);
        $this->middleware('can:offer,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $oferta = Oferta::orderBy(request()->order?:'id', request()->dir?:'ASC')
        ->where('licitacion_id', $request->num_id)
        ->search(request()->search)
        ->paginate(request()->num?:10);
        $oferta->each(function ($o) {
            $o->nombre = $o->usuario->fullName();
            $o->date = $o->created_at->format('d-m-Y');
            $o->hour = $o->created_at->format('H:i:s');
            unset($o->usuario);
        });
        return $this->dataWithPagination($oferta);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $licitacion = Licitacion::findOrFail($request->licitacion_id);
        if ($licitacion->created_at->addDays($licitacion->tiempo) < \Carbon::now()) {
            return response()->json(['msg' => 'Ya esta cerrado el proceso de propuestas.'], 401);
        }
        $data = $request->validate([
            'licitacion_id' => 'required|numeric',
            'propuesta' => 'required|string|min:5|max:350'
        ],[],['licitacion_id' => 'licitación']);
        $data['usuario_id'] = \Auth::user()->id;
        $offer = Oferta::where('licitacion_id', $data['licitacion_id'])->where('usuario_id', $data['usuario_id'])->count();
        if ($offer) return response()->json(['msg' => 'Ya Hizo su Propuesta.'], 401);
        Oferta::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oferta = Oferta::findOrFail($id);
        $oferta->usuario;
        $oferta->usuario->fullName = $oferta->usuario->fullName();
        $oferta->licitacion;
        return response()->json($oferta);
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
        $data = $request->validate(['propuesta' => 'required|string|min:5|max:350']);
        Oferta::findOrFail($id)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Oferta::findOrFail($id)->delete();
    }
}
