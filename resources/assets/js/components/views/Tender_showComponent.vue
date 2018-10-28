<template>
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Licitación: {{ data.nombre }}</h3>
            <b class="pull-right">Presupuesto: {{ data.precio_minimo }}$ - {{ data.precio_maximo }}$</b>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img :src="(data.imagen !== null) ? data.imagen : '/images/39295.png'" :alt="data.slug" class="img-responsive img-circle">
                </div>
                <div class="col-md-9">
                    <h4>Empleado: {{ data.empresa.fullName }}</h4>
                    <p v-text="data.descripcion"></p>
                    <p>Area de Trabajo: <span class="label label-primary">{{ data.servicio }}</span></p>
                    <div class="col-md-6">Correo: {{ data.empresa.correo }}</div>
                    <div class="col-md-6">Pais: {{ data.empresa.pais }}</div>
                    <div class="col-md-6">Municipio: {{ data.empresa.municipio }}</div>
                    <div class="col-md-6">Sector: {{ data.empresa.sector }}</div>
                    <div class="col-md-6">Código Postal: {{ data.empresa.codigo_postal }}</div>
                    <div class="col-md-6">Calle/Avenida: {{ data.empresa.calle_avenida }}</div>
                    <div class="row" v-if="!data.ev">
                        <div class="col-md-12" style="font-size: 20px">
                            <p>
                                Evaluación:
                                <a href="#" v-for="n in 5" style="padding: 3px"><i class="glyphicon" :class="(data.evaluacion >= n) ? 'glyphicon-star' : 'glyphicon-star-empty'"></i></a>
                            </p>
                            <p>
                                Comentario: <span v-text="data.comentario"></span>
                            </p>
                        </div>                                    
                    </div>
                    <div class="row" v-if="can('tender.store') && data.empresa_id && data.ev">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="evaluacion" class="control-label">Evaluación:</label>
                                <div class="row">
                                    <div class="col-md-12" style="font-size: 20px">
                                        <a href="#" v-for="n in 5" @click.prevent="data.evaluacion = n" style="padding: 3px"><i class="glyphicon" :class="(data.evaluacion >= n) ? 'glyphicon-star' : 'glyphicon-star-empty'"></i></a>
                                    </div>                                    
                                </div>
                                <small id="evaluacionHelp" class="form-text text-muted">Seleccione la valoración de su evaluación.</small>
                            </div>
                            <div class="form-group">
                                <label for="comentario" class="control-label">Comentario:</label>
                                <textarea id="comentario" class="form-control" rows="5" v-model="data.comentario"></textarea>
                                <small id="comentarioHelp" class="form-text text-muted">Registre aqui su comentario laboral.</small>
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-top: 28px">
                            <button type="button" class="btn btn-primary" @click="register">
                                Registrar<br>Evaluación
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'Offer',
        data() {
            return {
                test: false,
                data: {
                    empresa: ''
                },
            };
        },
        mounted() {
            axios.get('/mytenders/' + this.$route.params.id)
            .then(response => {
                this.data = response.data;
                if (this.data.offer) this.test = true;
            });
        },
        methods: {
            register: function () {
                axios.post('/tenders', {
                    evaluacion: this.data.evaluacion,
                    comentario: this.data.comentario,
                    id: this.data.id
                })
                .then(response => {
                    toastr.success('Evaluación Agregada');
                    this.$router.push('/mis-licitaciones');
                });
            },
        }
    }
</script>
