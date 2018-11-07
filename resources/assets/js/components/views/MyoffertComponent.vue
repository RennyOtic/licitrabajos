<template>
    <div class="box box-primary">
        <div class="box-header text-center">
            <h3 class="box-title">Tabla de Ofertas:</h3>
            <button type="button"
            class="btn btn-default btn-xs"
            data-tool="tooltip"
            title="Borrar"
            @click="deleted('/my-offerts/'+id, $children)"
            v-show="id"
            v-if="can('myOffer.destroy')"><span class="glyphicon glyphicon-trash"></span></button>
        </div>
        <div class="box-body">
            <rs-table id="myofferts" :columns="tabla.columns" uri="/my-offerts" @output="id = arguments[0]"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'MyOfferts',
        components: {
            'rs-table': Tabla,
        },
        data() {
            return {
                id: null,
                tabla: {
                    columns: [
                    { title: 'Licitación', field: 'licitacion_id', sortable: true },
                    { title: 'Propuesta', field: 'propuesta', sortable: true },
                    { title: 'Estatus', field: 'estatus_id', sortable: true },
                    ]
                }
            };
        }
    }
</script>
