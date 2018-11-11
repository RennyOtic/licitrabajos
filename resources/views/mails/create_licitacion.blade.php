@extends('layouts.mail')

@section('end')
<div class="row">
	<div class="text-center">
		<h3>Oferta a: {{ $licitacion->nombre }}</h3>
		<b class="pull-right">Presupuesto: {{ $licitacion->precio_minimo }}$ - {{ $licitacion->precio_maximo }}$</b>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="text-center">
				<img src="{{ url('/storage/'.$licitacion->imagen) }}" alt="{{ $licitacion->slug }}" height="200">
			</div>
			<div>
				<p>Detalles: {{ $licitacion->descripcion }}.</p>
				<p>Area de Trabajo: <b>{{ $licitacion->servicio->nombre }}</b>.</p>
			</div>
			<div class="text-center">
				<a href="{{ url('/oferta/' . $licitacion->id) }}" class="btn btn-primary" style="font-size: 25px">¡OFERTAR!</a>
			</div>
		</div>
	</div>
</div>
@endsection
