/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import router from './router';
import App from './components/App.vue';

Vue.use(VueRouter);

// window.addEventListener('load', () => {
// 	let loader = document.getElementById('loader');
// 	loader.classList.add('fadeOut');
// });

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
	methods: {
		can: function (accion = null) {
			let permissions = this.$root.permissions;
			if (permissions === 'all-access') return true;
			if (permissions === 'no-access') return false;
			if (Array.isArray(accion)) {
				let isset = false;
				for(let i in accion) {
					isset = permissions.includes(accion[i]);
				}
				return isset;
			}
			return this.$root.permissions.includes(accion);
		},
		isFunction: function (functionToCheck) {
			return functionToCheck && {}.toString.call(functionToCheck) === '[object Function]';
		},
		updateTable: function (test) {
			for(let i in test) {
				if (this.isFunction(test[i].get)) {
					test[i].get();
					return;
				}
			}
		},
		select2_search: function (data, val) {
			if (Array.isArray(val)) {
				let a = [];
				for(let i in val) {
					for(let d in data) {
						if (data[d].text == val[i]) {
							a.push(data[d].id);
						}
					}
				}
				return a;
			} else {
				for(let i in data) {
					if (data[i].text == val) {
						return data[i].id;
					}
				}
			}
		},
		select2_options: function (data) {
			let options = [];
			for(let i in data) {
				options.push(data[i].text);
			}
			return options;
		},
		restoreMsg: function (msg) {
			for(let i in msg) {
				$('.modal small#'+i+'Help').text(msg[i]);
			}
		},
		deleted: function (url, table, name = 'nombre') {
			let msg = toastr;
			msg.options.tapToDismiss = false;
			axios.get(url)
			.then(response => {
				msg.info(response.data[name] + '<br /><br /><button id="btn-delete" type="button" class="btn btn-success">Si</button> <button id="no-delete" type="button" class="btn btn-danger" role="button">No</button>', 'Esta seguro de Borrar este Elemento?')
			})
			.then(() => {
				let self = this;
				$('button#btn-delete').click(function () {
					toastr.remove();
					toastr.clear();
					axios.delete(url)
					.then(response => {
						self.updateTable(table);
						toastr.success('Borrado Exitosamente');
					});
				});
				$('button#no-delete').click(function () {
					toastr.remove();
					toastr.clear();
				});
			});
		}
	}
});

Vue.component('spinner', require('./components/partials/spinner.vue'));

const app = new Vue({
	router,
	data: {
		permissions: [],
	},
	components: { App },
	mounted: function () {
		if (location.href.indexOf('/login') > 0) return;
		if (location.href.indexOf('/registro') > 0) return;

		axios.post('/app', {rs: 'p'})
		.then(response => {this.permissions = response.data;});
	},
}).$mount('#app');
