<template>
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Licitaciones:</h3>
        </div>
        <div class="box-body">
            <rs-table id="tenders" rs="2" uri="/tenders" @output="id = arguments[0]"></rs-table>
        </div>
    </div>
</template>

<script>
    import Tabla from './../partials/table.vue';

    export default {
        name: 'Tenders',
        components: {
            'rs-table': Tabla,
        }
    }
</script>
