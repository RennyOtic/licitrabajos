<template>
	<div class="box">
		<div class="box-header text-center">
			<h3 class="box-title">Tabla de Permisos: </h3>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Editar"
			@click="openform('edit')"
			v-show="id"><span class="glyphicon glyphicon-edit"></span></button>
		</div>
		<div class="box-body">
			<rs-table id="permission"
			:columns="tabla.columns"
			uri="/admin/permissions"
			@output="id = arguments[0]"></rs-table>
		</div>
		<rs-modal-form :formData="formData" @input="updateTable($children)"></rs-modal-form>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/modal-form-permission.vue';

	export default {
		name: 'Permissions',
		components: {
			'rs-table': Tabla,
			'rs-modal-form': Modal,
		},
		data() {
			return {
				id: null,
				formData: {
					ready: true,
					title: '',
					url: '',
					ico: '',
					cond: '',
					data:  {}
				},
				tabla: {
					columns: [
					{ title: 'Nombre', field: 'nombre', sortable: true },
					{ title: 'Descripción', field: 'descripcion', sortable: true },
					{ title: 'Activo', field: 'activo', sort: 'deleted_at', sortable: true, class: 'text-center' }
					]
				}
			};
		},
		methods: {
			openform: function (cond, id = null) {
				this.formData.ready = false;
				if (cond == 'edit') {
					this.formData.url = '/admin/permissions/' + this.id;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.ico = 'edit';
						this.formData.title = 'Editar Rol: ' + response.data.nombre;
						this.formData.data = response.data;
						$('#permission-form').modal('show');
						this.formData.ready = true;
					});
				}
				this.formData.cond = cond;
			}
		}
	}
</script>
