<template>
  <modal id="offer-form" w="lg">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-' + formData.cond"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <spinner v-if="!formData.ready"></spinner>
      <div class="row" v-else>
        <form @keyup.enter="registrar">
          <div class="row">
            <div class="table-response">
              <table class="table table-condensed table-hover table-bordered">
                <tbody>
                  <tr>
                    <th>Usuario</th>
                    <td>{{ formData.data.usuario.fullName }}</td>
                    <th>Correo</th>
                    <td>{{ formData.data.usuario.correo }}</td>
                    <th>Identificación</th>
                    <td>{{ formData.data.usuario.identificacion }}</td>
                  </tr>
                  <tr>
                    <th>País</th>
                    <th>Municipio</th>
                    <th>Calle/Avenida</th>
                    <th colspan="2">Sector</th>
                    <th>Código Postal</th>
                  </tr>
                  <tr>
                    <td>{{ formData.data.usuario.pais }}</td>
                    <td>{{ formData.data.usuario.municipio }}</td>
                    <td>{{ formData.data.usuario.calle_avenida }}</td>
                    <td colspan="2">{{ formData.data.usuario.sector }}</td>
                    <td>{{ formData.data.usuario.codigo_postal }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="row">
            <h4 class="text-center"><u>Propuesta:</u></h4>
            <p v-text="formData.data.propuesta"></p>
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

<style scoped="">
th {
  background-color: #e3e3e3;
}
</style>

<script>
  import Modal from './../partials/modal.vue';
  // import Input from './../partials/input.vue';
  // import Multiselect from 'vue-multiselect';

  export default {
    name: 'modal-form-offer',
    components: {
      'modal': Modal,
      // 'rs-input': Input,
      // 'rs-multiselect': Multiselect,
    },
    props: ['formData'],
    data () {
      return {
        // servicio: [],
        // entries: [
        // {label: 'Titulo', id: 'nombre', icon: 'fa fa-user'},
        // {label: 'Imagen', id: 'imagen', icon: 'fa fa-user', type: 'file', accept:"image/*"},
        // ],
        // entries2: [
        // {label: 'Precio Mínimo', id: 'precio_minimo', icon: 'fa fa-user', type: 'number', min: 0},
        // {label: 'Precio Maximo', id: 'precio_maximo', icon: 'fa fa-user', type: 'number', min: 0},
        // ],
        // msg: {
        //   nombre: 'Nombre de la Licitación.',
        //   imagen: 'Imagen Relacionada.',
        //   servicio_id: 'Area de servicio.',
        //   precio_minimo: 'Precio promedio.',
        //   precio_maximo: 'Precio promedio.',
        //   descripcion: 'Descripción general del problema.',
        //   tiempo: 'Tiempo de espera de ofertas.',
        // }
      };
    },
    mounted: function () {
      // axios.post('/get-data-tenders')
      // .then(response => {this.servicio = response.data.servicio;});
    },
    methods: {
      registrar: function (el) {
        // this.restoreMsg(this.msg);
        // this.formData.data.servicio_id = this.select2_search(this.servicio, this.formData.data.servicio);
        // if (this.formData.cond == 'plus') {
        //   axios.post(this.formData.url, this.formData.data)
        //   .then(response => {
        //     toastr.success('Registro Exitoso');
        //     this.$emit('input');
        //     $('#mytender-form').modal('hide');
        //   });
        // } else {
        //   axios.put(this.formData.url, this.formData.data)
        //   .then(response => {
        //     toastr.success('Actualización Exitosa');
        //     this.$emit('input');
        //     $('#mytender-form').modal('hide');
        //   });
        // }
      }
    }
  }
</script>