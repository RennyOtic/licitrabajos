@extends('layouts.app')

@section('title', 'Registro | ')

@section('end')
<body class="hold-transition login-page layout-top-nav">
    <div id="app" class="wrapper">
        <div class="login-box">
            <div class="login-logo">
                {!! config('frontend.logo_lg') !!}
            </div>
            {{-- /.login-logo --}}
            <div class="login-box-body">
                <p class="login-box-msg">Ingresa para comenzar tu sesión.</p>

                <form method="POST" action="{{ url('register') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group has-feedback {{ $errors->has('nombre') ? 'has-error' : '' }}">
                                <label for="nombre" class="control-label">Nombre:</label>
                                <input id="nombre" type="text" class="form-control" name="nombre"  placeholder="Nombre" value="{{ old('nombre') }}" required autofocus>
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                @if ($errors->has('nombre'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('nombre') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('apellido') ? 'has-error' : '' }}">
                                <label for="apellido" class="control-label">Apellido:</label>
                                <input id="apellido" type="text" class="form-control" name="apellido"  placeholder="Apellido" value="{{ old('apellido') }}" required>
                                <span class="fa fa-user-o form-control-feedback"></span>
                                @if ($errors->has('apellido'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('apellido') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('identificacion') ? 'has-error' : '' }}">
                                <label for="identificacion" class="control-label">Cédula:</label>
                                <input id="identificacion" type="text" class="form-control" name="identificacion"  placeholder="######" value="{{ old('identificacion') }}" required>
                                <span class="fa fa-id-card-o form-control-feedback"></span>
                                @if ($errors->has('identificacion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('identificacion') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('correo') ? 'has-error' : '' }}">
                                <label for="correo" class="control-label">E-Mail:</label>
                                <input id="correo" type="email" class="form-control" name="correo"  placeholder="E-Mail" value="{{ old('correo') }}" required>
                                <span class="fa fa-envelope form-control-feedback"></span>
                                @if ($errors->has('correo'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('correo') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('pais') ? 'has-error' : '' }}">
                                <label for="pais" class="control-label">Pais:</label>
                                <input id="pais" type="text" class="form-control" name="pais"  placeholder="Chile" value="{{ old('pais') }}" required>
                                <span class="glyphicon glyphicon-globe form-control-feedback"></span>
                                @if ($errors->has('pais'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('pais') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('municipio') ? 'has-error' : '' }}">
                                <label for="municipio" class="control-label">Municipio:</label>
                                <input id="municipio" type="text" class="form-control" name="municipio"  placeholder="Región Metropolitana" value="{{ old('municipio') }}" required>
                                <span class="glyphicon glyphicon-fullscreen form-control-feedback"></span>
                                @if ($errors->has('municipio'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('municipio') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('sector') ? 'has-error' : '' }}">
                                <label for="sector" class="control-label">Sector:</label>
                                <input id="sector" type="text" class="form-control" name="sector"  placeholder="Independencia" value="{{ old('sector') }}" required>
                                <span class="glyphicon glyphicon-transfer form-control-feedback"></span>
                                @if ($errors->has('sector'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sector') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('calle_avenida') ? 'has-error' : '' }}">
                                <label for="calle_avenida" class="control-label">Calle / Avenida:</label>
                                <input id="calle_avenida" type="text" class="form-control" name="calle_avenida"  placeholder="Santos Dumont" value="{{ old('calle_avenida') }}" required>
                                <span class="glyphicon glyphicon-road form-control-feedback"></span>
                                @if ($errors->has('calle_avenida'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('calle_avenida') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('codigo_postal') ? 'has-error' : '' }}">
                                <label for="codigo_postal" class="control-label">Código Postal:</label>
                                <input id="codigo_postal" type="text" class="form-control" name="codigo_postal"  placeholder="999" value="{{ old('codigo_postal') }}" required>
                                <span class="glyphicon glyphicon-random form-control-feedback"></span>
                                @if ($errors->has('codigo_postal'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('codigo_postal') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('password') ? 'has-error' : '' }}">
                                <label for="password" class="control-label">Contraseña:</label>
                                <input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" required>
                                <span class="fa fa-lock form-control-feedback"></span>
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                <label for="password_confirmation" class="control-label">Confirmación:</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"  placeholder="Confirmación" required>
                                <span class="fa fa-lock form-control-feedback"></span>
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group has-feedback {{ $errors->has('rol') ? 'has-error' : '' }}">
                                <label for="rol" class="control-label">Perfil:</label>
                                <select id="rol" class="form-control" name="rol">
                                    @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('rol'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('rol') }}</strong>
                                </span>
                                @endif
                            </div>

                            <div class="col-xs-4 col-md-offset-8">
                                <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-box-body -->
        </div>
        <!-- /.login-box -->
    </div>
</body>
@endsection