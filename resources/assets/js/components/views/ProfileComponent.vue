<template>
    <div class="row box-primary">
        <div class="col-md-3">
            <div class="box box-primary">
                <div class="box-body box-profile">
                    <img class="profile-user-img img-responsive img-circle" :src="user.logoPath" :alt="user.fullName">

                    <h3 class="profile-username text-center" v-text="user.fullName"></h3>

                    <p class="text-muted text-center">{{ user.rol }}<br></p>

                    <p class="text-muted text-center" v-if="can('mytender.store')"><b>Proyecto Publicados: {{ user.projects_p }}</b></p>

                    <p class="text-muted text-center" v-if="can('offer.store')"><b>Proyecto Realizados: {{ user.projects_r }}</b></p>

                    <p class="text-muted text-center"><b>Miembro desde: {{ user.miembro }}</b></p>

                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Configuraciones</a></li>
                    <li><a href="#changePass" data-toggle="tab" aria-expanded="true">Cambio de Contraseña</a></li>
                    <li><a href="#address" data-toggle="tab" aria-expanded="true">Dirección</a></li>
                </ul>
                <div class="tab-content">
                    <div id="settings" class="tab-pane active">
                        <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="updateUser">
                            <div class="form-group"> <!-- has-feedback -->
                                <label for="nombre" class="col-sm-2 control-label">Nombres:</label>
                                <div class="col-sm-10">
                                    <input id="nombre" type="text" class="form-control" placeholder="Nombres" v-model="user.nombre">
                                    <small id="nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="apellido" class="col-sm-2 control-label">Apellidos:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="apellido" placeholder="Apellidos" v-model="user.apellido">
                                    <small id="last_nameHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="correo" class="col-sm-2 control-label">Correo:</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="correo" placeholder="Correo@dominio.com" v-model="user.correo">
                                    <small id="emailHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="identificacion" class="col-sm-2 control-label">Identificación:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="identificacion" placeholder="N° Identificación" v-model="user.identificacion">
                                    <small id="num_idHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="imagen" class="col-sm-2 control-label">Imagen:</label>
                                <div class="col-sm-10">
                                    <input type="file" id="image" class="form-control" name="image" @change="getImage" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group" v-if="can('user.service')">
                                <label for="imagen" class="col-sm-2 control-label">Area Servicio:</label>
                                <div class="col-sm-10">
                                    <rs-multiselect v-model="user.servicios" :options="select2_options(services)" :multiple="true" :hide-selected="true" :close-on-select="false"></rs-multiselect>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="address" class="tab-pane">
                        <form class="form-horizontal" enctype="multipart/form-data" @submit.prevent="updateAddress">
                            <div class="form-group">
                                <label for="pais" class="col-sm-2 control-label">Pais:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="pais" placeholder="Chile" v-model="user.pais">
                                    <small id="paisHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="municipio" class="col-sm-2 control-label">Municipio:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="municipio" placeholder="Región Metropolitana" v-model="user.municipio">
                                    <small id="municipioHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="sector" class="col-sm-2 control-label">Sector:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="sector" placeholder="Independencia" v-model="user.sector">
                                    <small id="sectorHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="calle_avenida" class="col-sm-2 control-label">Calle / Avenida:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="calle_avenida" placeholder="Santos Dumont" v-model="user.calle_avenida">
                                    <small id="calle_avenidaHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="codigo_postal" class="col-sm-2 control-label">Código Postal:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="codigo_postal" placeholder="999" v-model="user.codigo_postal">
                                    <small id="codigo_postalHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="changePass" class="tab-pane">
                        <form class="form-horizontal" @submit.prevent="changePass">
                            <div class="form-group">
                                <label for="passwordOld" class="col-sm-3 control-label">Contraseña Actual:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="passwordOld" placeholder="********" v-model="pass.passwordOld">
                                    <small id="passwordOldHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-3 control-label">Nueva Contraseña:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" placeholder="********" v-model="pass.password">
                                    <small id="passwordHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation" class="col-sm-3 control-label">Confirmar Contraseña:</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="********" v-model="pass.password_confirmation">
                                    <small id="password_confirmationHelp" class="form-text"></small>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <button type="submit" class="btn btn-success"> Guardar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';

    export default {
        components: {
            'rs-multiselect': Multiselect,
        },
        data() {
            return {
                services: [],
                user: {
                    fullName: '',
                    image: '',
                },
                pass: {
                    passwordOld: '',
                    password: '',
                    password_confirmation: ''
                }
            }
        },
        created() {
            axios.get('profile')
            .then(response => {
                this.user = response.data.user;
                this.services = response.data.servicio;
            });
        },
        methods: {
            getImage(e){
                this.user.image = e.target.files[0];
            },
            changePass() {
                axios.post('change-pass', this.pass)
                .then(response => {
                    this.pass.passwordOld = '';
                    this.pass.password = '';
                    this.pass.password_confirmation = '';
                    toastr.success('Contraseña Actualizada');
                });
            },
            updateAddress() {
                axios.post('/update-address', {
                    pais: this.user.pais,
                    municipio: this.user.municipio,
                    sector: this.user.sector,
                    calle_avenida: this.user.calle_avenida,
                    codigo_postal: this.user.codigo_postal,
                })
                .then(response => {toastr.success('Datos Actualizados');});
            },
            updateUser() {
                var data = new  FormData();
                data.append('image', this.user.image);
                data.append('nombre', this.user.nombre);
                data.append('apellido', this.user.apellido);
                data.append('correo', this.user.correo);
                data.append('identificacion', this.user.identificacion);
                data.append('servicios', this.select2_search(this.services, this.user.servicios));

                axios.post('/update-user', data)
                .then(response => {
                    toastr.success('Datos Actualizados');
                    window.location.reload();
                });
            }
        }
    }
</script>
