<template>
  <modal id="rol-form" w="lg">

    <template slot="modal-title">
      <span :class="'glyphicon glyphicon-'+formData.ico"></span>
      {{ formData.title }}
    </template>

    <template slot="modal-body">
      <form id="roles-form" @keyup.enter="registrar()">

        <spinner v-if="!formData.ready"></spinner>
        <div v-else>
          <div class="col-md-6" v-for="input in entries.izq">
            <rs-input :input="input"
            v-model="formData.data[input.id]"
            :msg="msg[input.id]"></rs-input>
            <!-- @input="formData.data[input.id] = arguments[0]" -->
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="especial" class="control-label">
                <span class="glyphicon glyphicon-calendar"></span> Caracteristica especial:
              </label>
              <select id="especial" v-model="formData.data.especial" class="form-control">
                <option :value="null">Ninguna</option>
                <option value="1">Acceso total</option>
                <option value="0">Sin acceso</option>
              </select>
              <small id="especialHelp" class="form-text text-muted">
                <span v-text="msg.especial"></span>
              </small>
            </div>
          </div>

          <div class="col-md-6" v-for="input in entries.der">
            <div class="form-group">
              <label :for="input.id" class="control-label">
                <span :class="'fa fa-'+input.icon"></span> {{ input.label }}
              </label>
              <date-picker id="" v-model="formData.data[input.id]" :config="{format: 'HH:mm:ss', useCurrent: false} " required="required"></date-picker>
              <small :id="input.id+'Help'" class="form-text text-muted">
                <span v-text="msg[input.id]"></span>
              </small>
            </div>
          </div>

          <rs-checkbox-p v-if="formData.data.especial === null"
          :user="formData.data.permisos"
          @check="formData.data.permisos = arguments[0]"></rs-checkbox-p>

        </div>
      </form>
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
  import datePicker from 'vue-bootstrap-datetimepicker';
  import Checkbox from './../partials/input-checkbox-permissions.vue';
  import 'eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css';
  
  export default {
    name: 'modal-form-rol',
    components: {
      'modal': Modal,
      'rs-input': Input,
      'rs-checkbox-p': Checkbox,
      datePicker
    },
    props: ['formData'],
    data () {
      return {
        entries: {
          izq: [
          {label: 'Nombre', id: 'nombre', icon: 'glyphicon glyphicon-compressed'},
          {label: 'Alias', id: 'slug', icon: 'edit'},
          {label: 'Descripción', id: 'descripcion', icon: 'edit'},
          ],
          der: [
          {label: 'Hora a comenzar la actividad', id: 'desde_at', icon: 'calendar'},
          {label: 'Hora a finalizar la actividad', id: 'hasta_at', icon: 'calendar'},
          ],
        },
        msg: {
          nombre: 'Nombre del rol.',
          slug: 'Alias del rol.',
          descripcion: 'Descripción del rol.',
          desde_at: 'Hora de actividad inicial.',
          hasta_at: 'Hora de actividad final.',
          especial: 'Acceso privilegiado.',
          permission: 'Permisos del rol'
        }
      };
    },
    methods: {
      registrar: function () {
        this.restoreMsg(this.msg);
        if (this.formData.cond === 'plus') {
          axios.post(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Rol Creado Exitosamente');
            this.$emit('input');
            $('#rol-form').modal('hide');
          });
        } else {
          axios.put(this.formData.url, this.formData.data)
          .then(response => {
            toastr.success('Rol Editado Exitosamente');
            this.$emit('input');
            $('#rol-form').modal('hide');
          });
        }
      }
    }
  }
</script>
