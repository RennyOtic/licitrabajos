<template>
	<div>
		<div class="col-md-2">
			<a href="#" style="width: 120px">
				<img :src="data.imagen" :alt="data.nombre" class="img-responsive img-circle" style="width: inherit;height: 120px;">
			</a>
		</div>
		<div class="col-md-8">
			<a href="#">
				<h3>{{ data.nombre }}. <small class="small">{{ data.desde }}.</small></h3>
			</a>
			<p v-text="data.descripcion"></p>
			<p>
				<a class="label label-primary" href="#" v-text="data.servicio.nombre"></a>
				<small class="small">Culmina {{ data.hasta }}.</small>
				<small class="text-danger" v-if="data.distancia">Esta a una distancia de: {{ data.distancia }}Km.</small>
			</p>
		</div>
		<div class="col-md-2 text-center">
			<p>
				<h4><b>${{ data.precio_minimo }} - ${{ data.precio_maximo }}</b></h4>
			</p>
			<p>{{ data.num_ofertas }} ofertas</p>
			<router-link v-if="can('offer.store')" :to="{ name: 'offer.store', params: { id: data.id } }" class="btn btn btn-success">Ofertar Ahora</router-link>
		</div>
	</div>
</template>

<script>
	export default {
		name: 'licitacion',
		props: ['data'],
	}
</script>