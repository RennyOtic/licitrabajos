<!DOCTYPE html>
	<html lang="{{ app()->getLocale() }}">
	<head>
		<meta charset="UTF-8">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<style>
        * {
        	font-family: helvetica;
        	box-sizing: border-box;
        }
        div {
        	font-size: 12pt;
        }
        .wrapper {
        	width: 700px;
        	margin: 0 auto;
        }
        header, footer {
            background-color: #ebebeb;
        }
        .row {
        	width: 100%;
        	margin-bottom: 15px;
        	clear: both;
        	display: table;
        	content: " ";
        }
        .d-inline {display: inline;}
        .pull-left {float: left; }
        .pull-right {float: right; }
        .text-center {text-align: center; }
        .text-left {text-align: left; }
        .text-right {text-align: right; }
        table {
        	width: 100%;
        	border: 1px solid #ddd;
        	width: 100%;
        	max-width: 100%;
        	margin-bottom: 20px;	
        	background-color: transparent;
        	border-spacing: 0;
        	border-collapse: collapse;
        }
        tr {
        	display: table-row;
        	vertical-align: inherit;
        	border-color: inherit;
        }
        th {
        	font-weight: bold;
        	background-color: #eee;
        }
        th, td {
        	border-top: 0;
        	border-bottom-width: 2px;
        	border: 1px solid #ddd;
        	padding: 1px 5px;
        	vertical-align: bottom;
        	line-height: 1.42857143;
        	text-align: left;
        	display: table-cell;
        }
        .page-break {
        	page-break-after: always;
        }
        h1, h2, h3, h4, h5, h6 {
        	margin: 0;
        	padding: 0;
        }
        .btn {
            display: inline-block;
            margin-bottom: 0;
            font-weight: normal;
            text-align: center;
            vertical-align: middle;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            text-transform: none;
            white-space: nowrap;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.6;
            border-radius: 4px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .btn-primary {
            background-color: #3c8dbc;
            border-color: #367fa9;
            border-radius: 3px;
            -webkit-box-shadow: none;
            box-shadow: none;
            border: 1px solid transparent;
            color: #fff;
        }
        a {
            text-decoration: none;
        }
    </style>
    </head>
    <body>
        <div class="wrapper">
            <header style="padding: 20px">
                <h2 class="text-center">{!! config('frontend.logo_lg') !!}</h2>
            </header>
            @yield('end')
            <footer class="row" style="padding: 20px">
                <div class="text-center">
                    <strong>Copyright &copy; {!! date('Y') !!}. {!! config('frontend.credits') !!}</strong>. Todos los derechos reservados.
                </div>
            </footer>
        </div>
    </body>
</html>
