<template>
  <modal id="user-form" w="lg">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-' + formData.ico"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <spinner v-if="!formData.ready"></spinner>
      <div class="row" v-else>
        <form @keyup.enter="registrar">

          <div class="col-sm-6" v-for="input in entries">
            <rs-input :input="input"
            v-model="formData.user[input.id]"
            :msg="msg[input.id]"></rs-input>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label for="roles" class="control-label">
                <span class="glyphicon glyphicon-compressed"></span> Roles:
              </label>
              <rs-multiselect v-model="formData.user.rol" :options="select2_options(roles)" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
              <small id="rolesHelp" class="form-text text-muted">
                <span v-text="msg.roles"></span>
              </small>
            </div>
          </div>

        </form>
      </div>
    </template>

    <template slot="modal-btn">
      <button type="button" class="btn btn-default" data-dismiss="modal"><span class="fa fa-close"></span> Cerrar</button>
      <button type="button" class="btn btn-primary" @click="registrar"><span class="glyphicon glyphicon-saved"></span> Guardar</button>
    </template>

  </modal>
</template>

<script>
  import Modal from './../partials/modal.vue';
  import Input from './../partials/input.vue';
  import Multiselect from 'vue-multiselect';

  export default {
    name: 'modal-form-user',
    components: {
      'modal': Modal,
      'rs-input': Input,
      'rs-multiselect': Multiselect,
    },
    props: ['formData'],
    data () {
      return {
        entries: [
        {label: 'Nombre', id: 'nombre', icon: 'fa fa-user'},
        {label: 'Contraseña', id: 'password', icon: 'fa fa-lock', type: 'password'},
        {label: 'Apellido', id: 'apellido', icon: 'fa fa-user-o'},
        {label: 'Confirmación de Contraseña', id: 'password_confirmation', icon: 'fa fa-lock', type: 'password'},
        {label: 'Cédula', id: 'identificacion', icon: 'fa fa-id-card-o'},
        {label: 'E-Mail', id: 'correo', icon: 'fa fa-envelope'},
        ],
        roles: [],
        msg: {
          nombre: 'Nombre del usuario.',
          apellido: 'Apellido del usuario.',
          identificacion: 'Cedula de identidad.',
          correo: 'Correo electronico.',
          password: 'Contraseña.',
          password_confirmation: 'Confirmación de Contraseña.',
          roles: 'Rol a desempeñar.',
        }
      };
    },
    mounted: function () {
      axios.post('/admin/get-data-users')
      .then(response => {this.roles = response.data.roles;});
    },
    methods: {
      registrar: function (el) {
        this.restoreMsg(this.msg);
        this.formData.user.roles = this.select2_search(this.roles, this.formData.user.rol);
        if (this.formData.cond === 'plus') {
          axios.post(this.formData.url, this.formData.user)
          .then(response => {
            toastr.success('Registro Exitoso');
            this.$emit('input');
            $('#user-form').modal('hide');
          });
        } else {
          axios.put(this.formData.url, this.formData.user)
          .then(response => {
            toastr.success('Actualización Exitosa');
            this.$emit('input');
            $('#user-form').modal('hide');
          });
        }
      }
    }
  }
</script>