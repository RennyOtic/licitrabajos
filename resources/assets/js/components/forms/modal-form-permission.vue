<template>
  <modal id="permission-form">

    <h4 class="card-title" slot="modal-title">
      <span class="glyphicon glyphicon-edit"></span>
      {{ formData.title }}
    </h4>

    <template slot="modal-body">
      <div class="row justify-content-center">
        <div class="col-md-10 col-md-offset-1">
          <form @keyup.enter="registrar">

            <spinner v-if="!formData.ready"></spinner>
            <div v-else>
              <template v-for="input in entries">
                <rs-input :input="input"
                v-model="formData.data[input.id]"
                :msg="msg[input.id]"></rs-input>
              </template>

              <div class="form-group">
                <label for="activo" class="control-label">
                  <span class="glyphicon glyphicon-inbox"></span> Activo:
                </label>
                <select id="activo" required="true" class="form-control" v-model="formData.data.activo">
                  <option :value="false">Activo</option>
                  <option :value="true">Inactivo</option>
                </select>
                <small id="activoHelp" class="form-text text-muted">
                  <span v-text="msg.activo"></span>
                </small>
              </div>
            </div>

          </form>
        </div>
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

  export default {
    name: 'modal-form-permission',
    components: {
      'modal': Modal,
      'rs-input': Input
    },
    props: ['formData'],
    data () {
      return {
        msg: {
          nombre: 'Nombre del Permiso.',
          descripcion: 'Descripción a realizar.',
          activo: 'Activar o Inactivar permiso.'
        },
        entries: [
        {label: 'Nombre', id: 'nombre', icon: 'edit'},
        {label: 'Descripción', id: 'descripcion', icon: 'edit'},
        ]
      };
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'edit') {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Registro Actualizado');
            this.$emit('input');
            $('#permission-form').modal('hide');
          });
        }
      }
    }
  }
</script>
