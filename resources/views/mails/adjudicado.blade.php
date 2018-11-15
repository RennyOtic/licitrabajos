@extends('layouts.mail')

@section('end')
<div class="row">
	<div class="text-center">
		<h3>
			<strong style="color: #0042aa;">
				Hola, {{ $licitacion->empresa->fullName() }}.
			</strong>
		</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="row text-center" style="line-height: 2">
				<b>{{ $licitacion->persona->fullName() }}</b>, ah aceptado tu propuesta en la licitación: <a href="{{ url('oferta/' . $licitacion->id) }}"><b>{{ $licitacion->nombre }}.</b></a>. Por favor, accede a nuestra aplicación y concreta los ultimos detalles.
			</div>
			<div class="text-center">
				<a href="{{ url('/chat/' . $licitacion->chat->first()->id) }}" class="btn btn-primary" style="font-size: 25px;color: #FFF">¡Ir al chat!</a>
			</div>
		</div>
	</div>
</div>
@endsection