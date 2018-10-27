<template>
	<div class="row">
		<template v-for="(module, keym, indexm) in modules">
			<div class="col-md-4">
				<div class="box box-primary">
					<div class="box-header"><b>{{ module }}.</b></div>
					<div class="box-body" style="font-size: 16px;">
						<table class="table table-hover">
							<tbody>
								<tr class="form-inline" v-for="(p, key, index) in permissions" v-if="p.modulo == keym">
									<td style="font-size:13px;">
										<label :for="'perm' + p.id" class="control-label">
											{{ p.nombre }}:
										</label>
									</td>
									<td>
										<input :id="'perm' + p.id" style="margin: 9px 0 0 5px" type="checkbox" :value="p.id" v-model="permissionsRol">
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</template>
	</div>
</template>

<script>
	export default {
		name: 'checkbox-permissions',
		props: ['user'],
		data () {
			return {
				permissionsRol: this.user,
				permissions: [],
				modules: {
					user: 'Usuarios',
					rol: 'Roles',
					permission: 'Permisos',
					tender: 'Licitaciones General',
					mytender: 'Licitaciones Propias del Usuario',
					offer: 'Ofertas',
				},
			};
		},
		watch: {
			permissionsRol: function (val) {
				this.$emit('check', val);
			},
			user: function (val) {
				this.permissionsRol = val;
			}
		},
		mounted: function () {
			axios.post('/admin/get-data-roles')
			.then(response => {this.permissions = response.data.permissions;});
		}
	}
</script>
