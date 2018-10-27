<template>
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menú de Navegación</li>
        <li class="treeview" v-if="can(['user.index','rol.index','permission.index'])">
            <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Administración</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li v-if="can('user.index')">
                    <router-link :to="{ name: 'user.index' }">
                        <i class="fa fa-users"></i> Usuarios
                    </router-link>
                </li>
                <li v-if="can('rol.index')">
                    <router-link :to="{ name: 'rol.index' }">
                        <i class="glyphicon glyphicon-compressed"></i> Roles
                    </router-link>
                </li>
                <li v-if="can('permission.index')">
                    <router-link :to="{ name: 'permission.index' }">
                        <i class="glyphicon glyphicon-th"></i> Permisos
                    </router-link>
                </li>
            </ul>
        </li>
        <li v-if="can('tender.index')">
            <router-link :to="{ name: 'tender.index' }">
                <i class="fa fa-dashboard"></i> <span>Licitaciones</span>
            </router-link>
        </li>
        <li v-if="can('mytender.index')">
            <router-link :to="{ name: 'mytender.index' }">
                <i class="fa fa-dashboard"></i> <span>Mis Licitaciones</span>
            </router-link>
        </li>
    </ul>
</template>

<script>
    export default {}
</script>