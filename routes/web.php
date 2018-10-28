<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Rutas típicas de autentificación de la app.
 * reemplazando: Auth::routes();
 */
Route::group(['namespace' => 'Auth'], function () {
    // Rutas de Autentificación...
    Route::group(['middleware' => 'guest'], function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        // Rutas de Registro... 
        if (config('frontend.registration_open')) {
            Route::get('registro', 'RegisterController@showRegistrationForm')->name('register');
            Route::post('register', 'RegisterController@register');
        }
    });
    Route::post('logout', 'LoginController@logout')->name('logout');
});
Route::post('app', 'RouteController@dataForTemplate');

/**
 * Requieren autentificación y que sean por AJAX.
 */
Route::group(['middleware' => ['auth', 'onlyAjax']], function () {

    /**
     * Admin, Acceso para módulos de configuración.
     * "/admin/*"
     */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::'], function () {

        // Users Routes...
        Route::resource('users', 'UsersController')->except(['create', 'edit']);
        Route::post('get-data-users', 'UsersController@dataForRegister');

        // Roles Routes...
        Route::resource('roles', 'RolesController')->except(['create', 'edit']);
        Route::post('get-data-roles', 'RolesController@dataForRegister');

        // Permissions Routes...
        Route::resource('permissions', 'PermissionsController')->only(['index', 'show', 'update']);

    });

    // Licitaciones Routes...
    Route::resource('tenders', 'TendersController')->only(['index', 'store']);//->except(['create', 'edit', 'store']);

    // Mis Licitaciones Routes...
    Route::resource('mytenders', 'MyTendersController')->except(['create', 'edit']);
    Route::post('get-data-tenders', 'MyTendersController@dataForRegister');

    // Ofertas Routes...
    Route::resource('offers', 'OffersController')->except(['create', 'edit']);
    Route::post('get-data-offers', 'OffersController@dataForRegister');
    Route::post('accept', 'OffersController@accept');

    Route::group(['prefix' => '/', 'namespace' => 'Dashboard', 'as' => 'Dashboard::'], function () {
        Route::get('profile', 'ProfileController@show');
        Route::post('change-pass', 'ProfileController@editPassword');
        Route::post('update-user', 'ProfileController@editUser');
    });

    Route::post('admin/app', 'RouteController@canPermission');

});

/**
 * Requieren autentificación.
 */
Route::group(['middleware' => 'auth'], function () {
    /**
     * Admin, Acceso para módulos de configuración.
     * "/admin/*"
     */
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin::'], function () {
        Route::get('init-session-user/{id}', 'UsersController@initWithOneUser');
    });
});

Route::get('{any?}', 'RouteController@index')->where('any', '.*');
