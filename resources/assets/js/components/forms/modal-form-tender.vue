<template>
  <modal id="tender-form" w="lg">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-' + formData.cond"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <spinner v-if="!formData.ready"></spinner>
      <div class="row" v-else>
        <form @keyup.enter="registrar">

          <div class="col-md-6" v-for="input in entries">
            <rs-input :input="input"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"></rs-input>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="descripcion" class="control-label">
                <span class="edit"></span> Descripción:
              </label>
              <textarea id="descripcion" rows="2" class="form-control" v-model="formData.data.descripcion"></textarea>
              <small id="descripcionHelp" class="form-text text-muted" v-html="msg.descripcion"></small>
            </div>
          </div>

          <div class="col-md-4" v-for="input in entries2">
            <rs-input :input="input"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"></rs-input>
          </div>

          <div class="col-md-4">
            <div class="form-group">
              <label for="tiempo" class="control-label">
                <span class="edit"></span> Dias Activos de la Licitación:
              </label>
              <select id="tiempo" class="form-control" v-model="formData.data.tiempo">
                <option value="">Seleccione</option>
                <option v-for="n in 10" v-text="n"></option>
              </select>
              <small id="tiempoHelp" class="form-text text-muted" v-html="msg.tiempo"></small>
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

  export default {
    name: 'modal-form-tender',
    components: {
      'modal': Modal,
      'rs-input': Input,
    },
    props: ['formData'],
    data () {
      return {
        entries: [
        {label: 'Titulo', id: 'nombre', icon: 'fa fa-user'},
        {label: 'Imagen', id: 'imagen', icon: 'fa fa-user', type: 'file', accept:"image/*"},
        ],
        entries2: [
        {label: 'Precio Mínimo', id: 'precio_minimo', icon: 'fa fa-user', type: 'number', min: 0},
        {label: 'Precio Maximo', id: 'precio_maximo', icon: 'fa fa-user', type: 'number', min: 0},
        ],
        msg: {
          nombre: 'Nombre de la Licitación.',
          imagen: 'Apellido Relacionada.',
          precio_minimo: 'Precio promedio.',
          precio_maximo: 'Precio promedio.',
          descripcion: '.',
          tiempo: 'Confirmación de Contraseña.',
        }
      };
    },
    mounted: function () {
      // axios.post('/admin/get-data-users')
      // .then(response => {this.roles = response.data.roles;});
    },
    methods: {
      registrar: function (el) {
        this.restoreMsg(this.msg);
        // this.formData.user.roles = this.select2_search(this.roles, this.formData.user.rol);
        if (this.formData.cond === 'plus') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Registro Exitoso');
            this.$emit('input');
            $('#tender-form').modal('hide');
          });
        } else {
          // axios.put(this.formData.url, this.formData.user)
          // .then(response => {
          //   toastr.success('Actualización Exitosa');
          //   this.$emit('input');
          //   $('#user-form').modal('hide');
          // });
        }
      }
    }
  }
</script>