import VueRouter from 'vue-router';
import App from './components/App.vue';
import Dashboard from './components/views/DashboardComponent.vue';
import Profile from './components/views/profileComponent.vue';
import Users from './components/views/UsersComponent.vue';
import Roles from './components/views/RolesComponent.vue';
import Permissions from './components/views/PermissionsComponent.vue';
import Tenders from './components/views/TendersComponent.vue';
import Mytender from './components/views/MytenderComponent.vue';
import Myoffert from './components/views/MyoffertComponent.vue';
import Offer_S from './components/forms/form-offer.vue';
import Offer from './components/views/OfferComponent.vue';
import Tender_show from './components/views/Tender_showComponent.vue';
import Chat from './components/views/ChatComponent.vue';
import NotFound from './components/views/NotFoundComponent.vue';

const router = new VueRouter({
	mode: 'history',
	hashbang: false,
	routes: [
	{
		path: '/',
		name: 'dashboard',
		component: Dashboard,
	},
	{
		path: '/perfil',
		name: 'profile',
		component: Profile,
	},
	{
		path: '/administracion/',
		component: {template: `<router-view></router-view>`},
		children: [
		{
			path: '/usuarios',
			name: 'user.index',
			component: Users,
		},
		{
			path: '/roles',
			name: 'rol.index',
			component: Roles,
		},
		{
			path: '/permisos',
			name: 'permission.index',
			component: Permissions,
		},
		{
			path: '*',
			component: NotFound,
		}
		]
	},
	{ 
		path: '/licitaciones', 
		name: 'tender.index',
		component: Tenders
	},
	{ 
		path: '/mis-licitaciones', 
		name: 'mytender.index',
		component: Mytender
	},
	{ 
		path: '/oferta/:id', 
		name: 'offer.store',
		component: Offer_S
	},
	{ 
		path: '/ver-oferta/:id', 
		name: 'offer.index',
		component: Offer
	},
	{ 
		path: '/licitacion/:id', 
		name: 'tender.show',
		component: Tender_show
	},
	{ 
		path: '/ofertas', 
		name: 'myOfferts.index',
		component: Myoffert
	},
	{ 
		path: '/chat/:id?', 
		name: 'chat.index',
		component: Chat
	},
	{
		path: '*', 
		name: 'error',
		component: NotFound
	}
	],
});

router.beforeEach((to, from, next) => {
	let permission = to.name;
	if (location.href.indexOf('/login') > 0) return;
	if (location.href.indexOf('/registro') > 0) return;
	if (permission == undefined) {next('error'); return;}
	if (to.path.indexOf('.jpg') > 0 ||
		to.path.indexOf('.jpeg') > 0 ||
		to.path.indexOf('.png') > 0 ||
		to.path.indexOf('.ttf') > 0 ||
		to.path.indexOf('.min') > 0 ||
		to.path.indexOf('.css') > 0) {
		next('/');
		return;
	}
	setTimeout(() => {
		if (to.path == '/') {
			setTimeout(() => {
				if (this.a.app.can('mytender.store')) next('/mis-licitaciones');
				if (this.a.app.can('offer.store')) next('/ofertas');
			}, 10)
			return;
		}
		if (this.a.app.can(permission)) {
			next(); return;
		} else if (permission.indexOf('-') != -1) {
			let split = permission.split('-');
			for(let i in split) {
				if (split[i].indexOf('.index') != -1) {
					if (this.a.app.can(split[i])) {
						next(); return;
					}
				} else {
					if (this.a.app.can(split[i] + '.index')) {
						next(); return;
					}
				}
			}
		}
		axios.post('/admin/app', {p: permission})
		.then(response => {
			if (response.data) {next(); return;}
			next(false);
		});
	}, 10);
});

router.afterEach((to, from, next) => {
	setTimeout(function () {
		$('[data-tool="tooltip"]').tooltip();
	}, 1000);
});
export default router;