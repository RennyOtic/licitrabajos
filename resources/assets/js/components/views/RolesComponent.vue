<template>
	<div class="box box-primary">
		<div class="box-header text-center">
			<h3 class="box-title">Tabla de Roles: </h3>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Registrar Rol"
			@click="openform('plus')"
			v-if="can('rol.store')"><span class="glyphicon glyphicon-plus"></span></button>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Editar Rol"
			@click="openform('edit')"
			v-show="id"
			v-if="can('rol.update')"><span class="glyphicon glyphicon-edit"></span></button>
			<button type="button"
			class="btn btn-default btn-xs"
			data-tool="tooltip"
			title="Borrar Rol"
			@click="deleted('/admin/roles/'+id, $children)"
			v-show="id"><span class="glyphicon glyphicon-trash"></span></button>
		</div>
		<div class="box-body">
			<rs-table id="rol" :columns="tabla.columns" uri="/admin/roles" @output="id = arguments[0]"></rs-table>
		</div>
		<rs-modal-form :formData="formData" @input="updateTable($children)"></rs-modal-form>
	</div>
</template>

<script>
	import Tabla from './../partials/table.vue';
	import Modal from './../forms/modal-form-rol.vue';

	export default {
		name: 'Roles',
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
					{ title: 'Activo', field: 'hours', sort: 'from_at', sortable: true },
					{ title: 'Acceso especial', field: 'especial', class: 'text-center' },
					]
				}
			};
		},
		methods: {
			openform: function (cond, id = null) {
				this.formData.ready = false;
				this.formData.ico = cond;
				this.formData.cond = cond;
				if (cond == 'plus') {
					this.formData.title = ' Registrar Rol.';
					this.formData.url = '/admin/roles';
					this.formData.data = {
						nombre: '',
						slug: '',
						descripcion: '',
						desde_at: '',
						especial: null,
						hasta_at: '',
						permisos: []
					};
					this.formData.ready = true;
				} else if (cond == 'edit') {
					this.formData.url = '/admin/roles/' + this.id;
					axios.get(this.formData.url)
					.then(response => {
						this.formData.title = 'Editar Rol: ' + response.data.nombre;
						this.formData.data = response.data;
						this.formData.ready = true;
					});
				}
				$('#rol-form').modal('show');
			}
		}
	}
</script>
