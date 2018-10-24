<template>
    <header class="main-header">
        <router-link :to="{ name: 'dashboard' }" class="logo">
            <span class="logo-mini" v-html="all.L.Lm"></span>
            <span class="logo-lg" v-html="all.L.Lg"></span>
        </router-link>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Menú</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img :src="all.user.logoPath" class="user-image" alt="">
                            <span class="hidden-xs" v-text="all.user.fullName"></span>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img :src="all.user.logoPath" class="img-circle" :alt="all.user.fullName">
                                <p>
                                    {{ all.user.fullName }}.
                                    <div class="row">
                                        <p class="small">Miembro desde {{ all.user.from }}.</p>
                                    </div>
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    <router-link :to="{ name: 'profile' }" class="btn btn-default btn-flat" data-toggle="tooltip" title="Perfil">
                                        <span class="fa fa-user"></span>
                                    </router-link>
                                </div>
                                <div class="pull-right">
                                    <a href="#" data-toggle="tooltip" title="Salir" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <span class="fa fa-lock"></span>
                                    </a>
                                    <form id="logout-form" action="/logout" method="POST" style="display:none;">
                                        <input type="hidden" name="_token" :value="token">
                                        <input type="hidden" name="_method" value="POST">
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
</template>

<script>
    export default {
        name: 'v-header',
        props: ['all'],
        data()  {
            return {
                token: window.token.content
            }
        },
    }
</script>
