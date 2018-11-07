<template>
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">Tabla de Ofertas:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Ver"
            @click="openform('show')"
            v-show="id"
            v-if="can('offer.update')"><span class="fa fa-eye"></span></button>
        </div>
        <div class="box-body">
            <rs-table id="offers" :columns="tabla.columns" uri="/offers" :num_id="$route.params.id" @output="id = arguments[0]"></rs-table>
        </div>
        <rs-modal-form :formData="formData" @input="updateTable($children)" v-if="can(['offer.store','offer.update'])"></rs-modal-form>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Modal from './../forms/modal-form-offer.vue';

    export default {
        name: 'offers',
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
                    cond: '',
                    data:  {
                        usuario: {}
                    }
                },
                tabla: {
                    columns: [
                    { title: 'Trabajador', field: 'nombre'},
                    { title: 'Detalles', field: 'propuesta', sortable: true },
                    { title: 'Estatus', field: 'estatus_id', sortable: true },
                    { title: 'Fecha', field: 'date' },
                    { title: 'Hora', field: 'hour' },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id = null) {
                this.formData.ready = false;
                this.formData.cond = cond;
                if (cond == 'plus') {
                } else if (cond == 'edit' || cond == 'show') {
                    this.formData.url = '/offers/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        if (cond == 'show') {
                            this.formData.title = 'Ver Propuesta de: ' + response.data.usuario.fullName + '.';
                        } else {
                            this.formData.title = 'Editar Propuesta de: ' + response.data.usuario.fullName + '.';
                        }
                        this.formData.data = response.data;
                        this.formData.ready = true;
                    });
                    if (cond == 'show') {
                        $('#offer-form').modal('show');
                        return;
                    }
                }
            }
        }
    }
</script>
