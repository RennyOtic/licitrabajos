<template>
    <div class="box">
        <div class="box-header text-center">
            <h3 class="box-title">Oferta a: {{ data.nombre }}</h3>
            <b class="pull-right">Presupuesto: {{ data.precio_minimo }}$ - {{ data.precio_maximo }}$</b>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img :src="data.imagen" :alt="data.slug" class="img-responsive img-circle">
                </div>
                <div class="col-md-9">
                    <h3>Detalles:</h3>
                    <p v-text="data.descripcion"></p>
                    <p>Area de Trabajo: <span class="label label-primary">{{ data.servicio }}</span></p>
                    <div class="row" v-if="can(['offer.store','offer.update','offer.destroy'])">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="propuesta" class="control-label">Propuesta:</label>
                                <textarea id="propuesta" class="form-control" rows="5" v-model="data.propuesta" :readonly="test"></textarea>
                                <small id="propuestaHelp" class="form-text text-muted">Registre aqui su propuesta laboral de una forma detallada.</small>
                            </div>
                        </div>
                        <div class="col-md-2" style="margin-top: 28px">
                            <button type="button" class="btn btn-primary" @click="register" v-if="can('offer.store') && !test">
                                Registrar<br>Propuesta
                            </button>
                            <template v-if="can(['offer.update','offer.destroy']) && test">
                                <button type="button" class="btn btn-info" @click="test = !test" v-if="can('offer.update') && data.offer">
                                    Editar
                                </button>
                                <br><br>
                                <button type="button" class="btn btn-danger" @click="del" v-if="can('offer.destroy')">
                                    Borrar
                                </button>
                            </template>
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
                data: [],
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
                if (this.data.offer) {
                    axios.put('/offers/' + this.data.offer, {propuesta: this.data.propuesta})
                    .then(response => {
                        toastr.success('Propuesta Actializada');
                        this.$router.push('/licitaciones');
                    });
                } else {
                    axios.post('/offers', {
                        licitacion_id: this.$route.params.id,
                        propuesta: this.data.propuesta,
                    })
                    .then(response => {
                        toastr.success('Propuesta Registrada');
                        this.$router.push('/licitaciones');
                    });
                }
            },
            del: function () {
                axios.delete('/offers/' + this.data.offer)
                .then(response => {
                    this.$router.push('/licitaciones');
                });
            }
        }
    }
</script>
