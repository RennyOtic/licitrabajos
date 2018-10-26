<template>
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Oferta a: {{ data.nombre }}</h3>
            <b class="pull-right">Presupuesto: {{ data.precio_minimo }}$ - {{ data.precio_maximo }}$</b>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <a href="#" style="width: 120px">
                        <img :src="(data.imagen !== null) ? data.imagen : '/images/39295.png'" :alt="data.slug" class="img-responsive img-circle">
                    </a>
                </div>
                <div class="col-md-9">
                    <h3>Detalles:</h3>
                    <p v-text="data.descripcion"></p>
                    <p>
                        Area de Trabajo: <span class="label label-primary">{{ data.servicio }}</span>
                    </p>
                    <div class="col-md-12">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="propuesta" class="control-label">Propuesta:</label>
                                <textarea id="propuesta" class="form-control" rows="5" v-model="data.propuesta"></textarea>
                                <small id="propuestaHelp" class="form-text text-muted">Propuesta laboral.</small>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-primary">Agregar Propuesta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // import Tabla from './../partials/table.vue';
    // import Modal from './../forms/modal-form-tender.vue';

    export default {
        name: 'Offer',
        components: {
            // 'rs-table': Tabla,
            // 'rs-modal-form': Modal,
        },
        data() {
            return {
                data: [],
                // id: null,
                // formData: {
                //     ready: true,
                //     title: '',
                //     url: '',
                //     cond: '',
                //     data:  {}
                // },
                // tabla: {
                //     columns: [
                //     { title: 'Titulo', field: 'nombre', sortable: true },
                //     { title: 'Detalles', field: 'descripcion', sortable: true },
                //     { title: 'Empleado', field: 'empresa_id', sortable: true },
                //     { title: 'Estatus', field: 'status_id', sortable: true },
                //     { title: 'Promedio de precio', field: 'promedio', sort: 'precio_minimo', sortable: true },
                //     ]
                // }
            };
        },
        mounted() {
            axios.get('/mytenders/' + this.$route.params.id)
            .then(response => {this.data = response.data;});
        },
        methods: {
            openform: function (cond, id = null) {
                // this.formData.ready = false;
                // this.formData.cond = cond;
                // if (cond == 'plus') {
                //     this.formData.title = 'Registrar Licitación.';
                //     this.formData.url = '/mytenders';
                //     this.formData.data = {
                //         nombre: '',
                //         descripcion: '',
                //         imagen: '',
                //         tiempo: '',
                //         precio_minimo: '',
                //         precio_maximo: '',
                //     };
                //     this.formData.ready = true;
                // } else if (cond == 'edit') {
                //     this.formData.url = '/mytenders/' + this.id;
                //     axios.get(this.formData.url)
                //     .then(response => {
                //         this.formData.title = 'Editar Licitación: ' + response.data.name + '.';
                //         this.formData.data = response.data;
                //         this.formData.ready = true;
                //     });
                // }
                // $('#mytender-form').modal('show');
            }
        }
    }
</script>
