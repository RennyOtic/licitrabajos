<template>
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Licitaciones:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Registrar"
            @click="openform('plus')"
            v-if="can('tender.store')"><span class="glyphicon glyphicon-plus"></span></button>
            <!-- <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Editar Usuario"
            @click="openform('edit')"
            v-show="id"
            v-if="can('tender.update')"><span class="glyphicon glyphicon-edit"></span></button> -->
            <!-- <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Borrar Usuario"
            @click="deleted('/admin/users/'+id, $children, 'fullName')"
            v-show="id"
            v-if="can('tender.destroy')"><span class="glyphicon glyphicon-trash"></span></button> -->
            <!-- <a class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Iniciar Sesión"
            v-show="id"
            v-if="can('tender.initWithOneUser')"
            :href="'/admin/init-session-user/'+id"><span class="glyphicon glyphicon-user"></span></a> -->
        </div>
        <div class="box-body">
            <rs-table id="tenders" rs="2" :columns="tabla.columns" uri="/tenders" @output="id = arguments[0]"></rs-table>
        </div>
        <rs-modal-form :formData="formData" @input="updateTable($children)" v-if="can(['tender.store','tender.update'])"></rs-modal-form>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';
    import Modal from './../forms/modal-form-tender.vue';

    export default {
        name: 'Tenders',
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
                    // { title: 'Nombre y Apellido', field: 'fullName', sort: 'name', sortable: true },
                    // { title: 'Cédula', field: 'identificacion', sortable: true },
                    // { title: 'Correo', field: 'correo', sortable: true },
                    // { title: 'Rol', field: 'rol' },
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
                    this.formData.url = '/tenders';
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
                    // this.formData.url = '/admin/users/' + this.id;
                    // axios.get(this.formData.url)
                    // .then(response => {
                    //     this.formData.title = 'Editar Usuario: ' + response.data.fullName + '.';
                    //     this.formData.user = response.data;
                    //     this.formData.ready = true;
                    // });
                }
                $('#tender-form').modal('show');
            }
        }
    }
</script>
