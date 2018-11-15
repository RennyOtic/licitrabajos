@extends('layouts.mail')

@section('end')
<div class="row">
	<div class="text-center">
		<h3>
			<strong style="color: #0042aa;">
				Bienvenid@ {{ $user->fullName() }}
			</strong>
		</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="row text-center" style="line-height: 2">
				Bienvenido a LICITRABAJOS, 
				aqui podras 
				@if($user->rol->first()->id == 2)	
				realizar ofertas a las licitaciones y ayudar a otros usuarios a darle solución a su propuesta.
				@endif
				@if($user->rol->first()->id == 3)
				realizar licitaciones para que otros usuarios competentes puedan darle solución a tu propuesta.
				@endif
			</div>
			<div class="text-center">
				<a href="{{ url('/perfil') }}" class="btn btn-primary" style="font-size: 25px;color: #FFF">¡Completa Tu Perfil!</a>
			</div>
		</div>
	</div>
</div>
@endsection