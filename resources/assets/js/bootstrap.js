
window._ = require('lodash');

window.toastr = require('toastr');

window.moment = require('moment');
moment.locale('es');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass/assets/javascripts/bootstrap.js');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

window.token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': token.content,
			'X-Auth-Token' : token.content
		}
	});

	window.Laravel = {"csrfToken": token.content};
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Agregar un interceptor de solicitud
axios.interceptors.request.use(function (config) {
	// Hace algo antes de enviar la solicitud

	if (location.href.indexOf('/perfil') > 0) $('small').removeClass('text-danger').addClass('text-muted').text('');
	if (location.href.indexOf('/perfil') == -1) {
		// $('input, select').parent().removeClass('has-error');
		$('small').removeClass('text-danger').addClass('text-muted');
	}
	$('button').removeAttr('disabled')
	// $('small').parent().find('input, select').removeClass('is-invalid');
	// $('.modal small').removeClass('text-danger').addClass('text-muted');
	return config;
}, function (error) {
	// Hacer algo con un error de solicitud
	return Promise.reject(error);
});

// Añadir un interceptor de respuesta
axios.interceptors.response.use(function (response) {
	// Hacer algo con los datos de respuesta
	return response;
}, function (error) {
	// Hacer algo con un error de respuesta
	errors = error.response;
	if (errors.status >= 500) {
		// window.location.reload();
		toastr.warning('Error en el servidor');
	}
	if (errors.status == 401) {
		toastr.error(errors.data.msg);
		setTimeout(function(){console.clear();},100);
	}
	if (errors.status == 422) {
		$('button, input').removeAttr('disabled')
		errors = errors.data.errors;
		// console.log(error.response.data)
		for(let e in errors) {
			// console.log($('small#' + e + 'Help'))
			$('small#' + e + 'Help').addClass('text-danger').text(errors[e][0]);
		}
		toastr.warning('Error al realizar operación');
		// if (errors.msg) toastr.warning(errors.msg);
		// setTimeout(function () {console.clear();},100);
	}
	return Promise.reject(error);
});

toastr.options = {
	closeButton: true,
	newestOnTop: true,
	progressBar: false,
	preventDuplicates: true,
	positionClass: "toast-top-right",
	showDuration: "300",
	hideDuration: "1000",
	timeOut: "5000",
	extendedTimeOut: "1000",
	showEasing: "swing",
	hideEasing: "linear",
	showMethod: "fadeIn",
	hideMethod: "fadeOut"
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });
