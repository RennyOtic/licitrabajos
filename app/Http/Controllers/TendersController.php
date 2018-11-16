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
        $select = ['id', 'nombre', 'descripcion', 'empresa_id', 'status_id', 'precio_minimo', 'precio_maximo', 'created_at', 'imagen', 'servicio_id', 'tiempo', 'persona_id'];
        $licitacion = Licitacion::orderBy(request()->order?:'id', request()->dir?:'ASC')
        ->where('tiempo_total', '>=', \Carbon::now())
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
            $point1 = array("lat" => \Auth::user()->latitude, "long" => \Auth::user()->longitude);
            $point2 = array("lat" => $l->persona->latitude, "long" => $l->persona->longitude);
            // $point2 = array("lat" => "19.4341667", "long" => "-99.1386111"); // Ciudad de México (México)
            $km = Self::distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long']); // Calcular la distancia en kilómetros (por defecto)
            // $mi = Self::distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'mi'); // Calcular la distancia en millas
            // $nmi = Self::distanceCalculation($point1['lat'], $point1['long'], $point2['lat'], $point2['long'], 'nmi'); // Calcular la distancia en millas naúticas
            // echo "La distancia entre París (Francia) y la Ciudad de México (México) es de $km km (= $mi millas = $nmi millas naúticas)";
            $l->distancia = $km;
            unset($l->ofertas);
        });
        return $this->dataWithPagination($licitacion);
    }

    protected function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
        // Cálculo de la distancia en grados
        $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
        // Conversión de la distancia en grados a la unidad escogida (kilómetros, millas o millas naúticas)
        switch($unit) {
            case 'km':
            $distance = $degrees * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
            break;
            case 'mi':
            $distance = $degrees * 69.05482; // 1 grado = 69.05482 millas, basándose en el diametro promedio de la Tierra (7.913,1 millas)
            break;
            case 'nmi':
            $distance =  $degrees * 59.97662; // 1 grado = 59.97662 millas naúticas, basándose en el diametro promedio de la Tierra (6,876.3 millas naúticas)
        }
        return round($distance, $decimals);
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
