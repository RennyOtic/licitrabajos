<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ { Oferta, Licitacion, Estatus, Chat };

class OffersController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:offer,index')->only(['index', 'dataForRegister']);
        $this->middleware('can:offer,store')->only(['store']);
        $this->middleware('can:offer,show')->only(['show']);
        $this->middleware('can:offer,update')->only(['update']);
        $this->middleware('can:offer,destroy')->only(['destroy']);
        $this->middleware('can:offer,accept')->only(['accept']);
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
            if ($o->estatus_id == 2) {
                $chat = Chat::where('licitacion_id', $o->licitacion_id)
                ->where('persona_id', $o->licitacion->persona_id)
                ->where('empresa_id', $o->usuario_id)
                ->first();
                if ($chat) {
                    $o->nombre = '<a href="/chat/' . $chat->id . '">' . $o->usuario->fullName() . '</a>';
                } else {
                    $o->nombre = $o->usuario->fullName();
                }
            } else {
                $o->nombre = $o->usuario->fullName();
            }
            $o->estatus_id = optional($o->estatus)->nombre;
            $o->reputacion = '';
            $divisor = $o->usuario->licitaciones2->where('evaluacion', '>', 0)->count();
            $dividendo = $o->usuario->licitaciones2->where('evaluacion', '>', 0)->sum('evaluacion');
            if ($divisor == 0) {
                    $o->reputacion = 'No ha sido Evaluado';
            } else {
                    $reputacion = $dividendo / $divisor;
                    for ($i = 0; $i < 5; $i++) { 
                        $o->reputacion .= "<i class='glyphicon ".(($reputacion > $i) ? 'glyphicon-star' : 'glyphicon-star-empty')."'></i>";
                    }
            }
            $o->date = $o->created_at->format('d-m-Y');
            $o->hour = $o->created_at->format('H:i:s');
            unset($o->usuario, $o->licitacion);
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
        $data['estatus_id'] = 1;
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

    public function dataForRegister()
    {
        $estatus = Estatus::get(['id', 'nombre']);
        return response()->json(compact('estatus'));
    }

    public function accept(Request $request)
    {
        $oferta = Oferta::findOrFail($request->id);
        $licitacion = Licitacion::findOrFail($oferta->licitacion_id);
        if ($licitacion->evaluacion) return response()->json(['msg' => 'Ye fue evaluada esta licitación'], 401);
        $licitacion->update(['empresa_id' => null, 'status_id' => 1]);
        if ($request->estatus == 2) {
            $licitacion->ofertas->each->update(['estatus_id' => 3]);
            $licitacion->update(['empresa_id' => $oferta->usuario_id, 'status_id' => 2]);
            $chat = Chat::where('persona_id', $licitacion->persona_id)
            ->where('empresa_id', $licitacion->empresa_id)
            ->first();
            if ($chat) {
                $chat->update(['licitacion_id' => $licitacion->persona_id]);
            } else {
                Chat::create([
                    'licitacion_id' => $licitacion->id,
                    'persona_id' => $licitacion->persona_id,
                    'empresa_id' => $oferta->usuario_id
                ]);
            }
            \Mail::to($oferta->usuario->correo)->send(new \App\Mail\ProyectoAdjudicado($licitacion));
        }
        $oferta->update(['estatus_id' => $request->estatus]);
    }
}
