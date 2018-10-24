@extends('layouts.app')

@section('title', 'Login | ')

@section('end')
<body class="hold-transition login-page layout-top-nav">
    <div id="app" class="wrapper">
        <div class="login-box">
            <div class="login-logo">
                {!! config('frontend.logo_lg') !!}
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Ingresa para comenzar tu sesión.</p>

                <form action="{{ route('login') }}" method="post">
                    @csrf

                    <div class="form-group has-feedback {{ $errors->has('correo') ? 'has-error' : '' }}">
                        <label for="correo" class="control-label">Correo:</label>
                        <input id="correo" type="email" class="form-control" name="correo"  placeholder="Email" value="@if(env('APP_ENV') == 'local'){{ 'root@licitrabajos.com' }}@else{{ old('correo') }}@endif" required autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                        @if ($errors->has('correo'))
                        <span class="help-block">
                            <strong>{{ $errors->first('correo') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }} has-feedback">
                        <label for="password" class="control-label">Contraseña:</label>
                        <input id="password" type="password" class="form-control" name="password"  placeholder="Contraseña" value="@if(env('APP_ENV')=='local'){{ 'secret' }}@endif" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                        @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label class="control control--checkbox">
                                    <input id="checkboxRemenber" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <div class="control__indicator"></div>
                                </label>
                                 <label for="checkboxRemenber" class="remenber">Recuérdame</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                        </div>
                    </div>
                </form>

                {{-- <a class="btn btn-link" href="{{ route('password.request') }}"> Forgot Your Password? </a> --}}
                {{-- <a href="#">Olvidé mi contraseña.</a><br> --}}
                @if(config('frontend.registration_open'))
                <a href="{{ route('register') }}">Registra nueva membresía.</a>
                @endif

            </div>
        </div>
    </div>
</body>
@endsection
