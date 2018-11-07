<template>
  <modal id="mytender-form" w="lg">

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

          <div class="col-md-6">
            <div class="form-group">
              <label for="imagen" class="control-label">
                <span class="fa fa-img"></span> Imagen
              </label>
              <input id="imagen"
              class="form-control" type="file" accept="image/*" @change="img">
              <small id="imagenHelp" class="form-text text-muted">{{ msg.imagen }}</small>
            </div>
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

          <div class="col-md-12">
            <div class="form-group">
              <label for="servicio_id" class="control-label">
                <span class="edit"></span> Area Servicio:
              </label>
              <rs-multiselect v-model="formData.data.servicio" :options="select2_options(servicio)" :hide-selected="true"></rs-multiselect>
              <small id="servicio_idHelp" class="form-text text-muted" v-html="msg.servicio_id"></small>
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
  import Multiselect from 'vue-multiselect';

  export default {
    name: 'modal-form-tender',
    components: {
      'modal': Modal,
      'rs-input': Input,
      'rs-multiselect': Multiselect,
    },
    props: ['formData'],
    data () {
      return {
        servicio: [],
        entries: [
        {label: 'Titulo', id: 'nombre', icon: 'fa fa-user'},
        ],
        entries2: [
        {label: 'Precio Mínimo', id: 'precio_minimo', icon: 'fa fa-user', type: 'number', min: 0},
        {label: 'Precio Maximo', id: 'precio_maximo', icon: 'fa fa-user', type: 'number', min: 0},
        ],
        msg: {
          nombre: 'Nombre de la Licitación.',
          imagen: 'Imagen Relacionada.',
          servicio_id: 'Area de servicio.',
          precio_minimo: 'Precio promedio.',
          precio_maximo: 'Precio promedio.',
          descripcion: 'Descripción general del problema.',
          tiempo: 'Tiempo de espera de ofertas.',
        }
      };
    },
    mounted: function () {
      axios.post('/get-data-tenders')
      .then(response => {this.servicio = response.data.servicio;});
    },
    methods: {
      img: function (e) {
        let data = new  FormData();
        data.append('img', e.target.files[0]);
        axios.post('/tenders-img', data)
        .then(response => {
          this.formData.data.imagen = response.data;
        });
      },
      registrar: function (el) {
        this.restoreMsg(this.msg);
        this.formData.data.servicio_id = this.select2_search(this.servicio, this.formData.data.servicio);
        if (this.formData.cond == 'plus') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Registro Exitoso');
            this.$emit('input');
            $('#mytender-form').modal('hide');
          });
        } else {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Actualización Exitosa');
            this.$emit('input');
            $('#mytender-form').modal('hide');
          });
        }
      }
    }
  }
</script>