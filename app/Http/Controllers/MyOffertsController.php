<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Oferta;

class MyOffertsController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:myOfferts,index')->only(['index']);
        $this->middleware('can:myOfferts,show')->only(['show']);
        $this->middleware('can:myOfferts,destroy')->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ofertas = Oferta::orderBy(request()->order?:'id', request()->dir?:'DESC')
        ->where('usuario_id', \Auth::user()->id)
        ->search(request()->search)
        ->paginate(request()->num?:10);
        $ofertas->each(function ($o) {
            $o->licitacion_id = $o->licitacion->nombre;
            $o->evaluacion = '';
            if ($o->licitacion->evaluacion != null) {
                for ($i = 0; $i < 5; $i++) { 
                    $o->evaluacion .= "<i class='glyphicon ".(($o->licitacion->evaluacion > $i) ? 'glyphicon-star' : 'glyphicon-star-empty')."'></i>";
                }
            }
            $o->estatus_id = '<span class="badge label-'.$o->color_status().'">' . $o->estatus->nombre . '</span>';

            unset($o->licitacion, $o->estatus);
        });
        return $this->dataWithPagination($ofertas);
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
        $oferta->nombre = 'Oferta a: ' . $oferta->licitacion->nombre;
        unset($oferta->licitacion);
        return response()->json($oferta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $oferta = Oferta::findOrFail($id);
        if ($oferta->estatus_id != 1) {
            return response()->json(['msg' => 'Esta Oferta no puede borrarse al ser ya evaluada'], 401);
        }
        $oferta->delete();
    }
}
