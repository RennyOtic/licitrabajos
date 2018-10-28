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
            <div class="col-md-8 col-md-offset-2" style="border: 3px solid #cacaca;border-radius: 15px;padding: 7px;">
              <p v-text="formData.data.propuesta"></p>
            </div>
          </div>
          <div class="row" v-if="can('offer.accept')">
            <div class="col-md-10 col-md-offset-1">
              <div class="form-group">
                <label for="estatus" class="control-label">Estatus de Propuesta:</label>
                <select id="estatus" class="form-control" v-model="formData.data.e">
                  <option value="">Seleccione una opción</option>
                  <option :value="e.id" v-for="e in estatus" v-text="e.nombre"></option>
                </select>
                <small id="estatushelp" class="form-text text-muted">Seleccione un estatus para esta propuesta.</small>
              </div>
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

<style scoped="">
th {background-color: #e3e3e3;}
</style>

<script>
  import Modal from './../partials/modal.vue';

  export default {
    name: 'modal-form-offer',
    components: {
      'modal': Modal,
    },
    props: ['formData'],
    data () {
      return {
        estatus: [],
      };
    },
    mounted: function () {
      axios.post('/get-data-offers')
      .then(response => {this.estatus = response.data.estatus;});
    },
    methods: {
      registrar: function (el) {
        if (this.formData.data.e == undefined) {
          return $('#offer-form').modal('hide');
        }
        axios.post('/accept', {
          estatus: this.formData.data.e,
          id: this.formData.data.id,
        })
        .then(response => {
          toastr.success('Registro Exitoso');
          this.$emit('input');
          $('#offer-form').modal('hide');
        });
      }
    }
  }
</script>