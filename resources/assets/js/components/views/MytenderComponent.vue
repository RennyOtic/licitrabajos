<template>
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Tabla de Licitaciones:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Registrar"
            @click="openform('plus')"
            v-if="can('mytender.store')"><span class="glyphicon glyphicon-plus"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Editar"
            @click="openform('edit')"
            v-show="id"
            v-if="can('mytender.update')"><span class="glyphicon glyphicon-edit"></span></button>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Borrar"
            @click="deleted('/mytenders/'+id, $children)"
            v-show="id"
            v-if="can('mytender.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
        </div>
        <div class="box-body">
            <rs-table id="mytenders" :columns="tabla.columns" uri="/mytenders" @output="id = arguments[0]"></rs-table>
        </div>
        <rs-modal-form :formData="formData" @input="updateTable($children)" v-if="can(['mytender.store','mytender.update'])"></rs-modal-form>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Modal from './../forms/modal-form-tender.vue';

    export default {
        name: 'MyTenders',
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
                    data:  {}
                },
                tabla: {
                    columns: [
                    { title: 'Titulo', field: 'nombre', sortable: true },
                    { title: 'Detalles', field: 'descripcion', sortable: true },
                    { title: 'Empleado', field: 'empresa_id', sortable: true },
                    { title: 'Estatus', field: 'status_id', sortable: true },
                    { title: 'Promedio de precio', field: 'promedio', sort: 'precio_minimo', sortable: true },
                    ]
                }
            };
        },
        methods: {
            openform: function (cond, id = null) {
                this.formData.ready = false;
                this.formData.cond = cond;
                if (cond == 'plus') {
                    this.formData.title = 'Registrar Licitación.';
                    this.formData.url = '/mytenders';
                    this.formData.data = {
                        nombre: '',
                        descripcion: '',
                        imagen: '',
                        tiempo: '',
                        precio_minimo: '',
                        precio_maximo: '',
                    };
                    this.formData.ready = true;
                } else if (cond == 'edit') {
                    this.formData.url = '/mytenders/' + this.id;
                    axios.get(this.formData.url)
                    .then(response => {
                        this.formData.title = 'Editar Licitación: ' + response.data.name + '.';
                        this.formData.data = response.data;
                        this.formData.ready = true;
                    });
                }
                $('#mytender-form').modal('show');
            }
        }
    }
</script>
