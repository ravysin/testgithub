<!doctype html>
<head>
	<meta charset="UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=10; IE=9; IE=8; IE=7; IE=EDGE" />
	<title>Human Resources Management</title>
    
    <?php $lang = Config::get('app.locale'); ?>
    {{HTML::style('datepicker/jsDatePick_ltr.min.css')}}
    {{HTML::style('css/menu.css')}}
    {{HTML::style('css/main.css')}}
    @if($lang=='kh')
        {{HTML::style('css/general_kh.css')}}
    @else
        {{HTML::style('css/general.css')}}
    @endif
    @yield('head')
</head>
<body>
    @if(Auth::check())
            <div class="header">@include('layout.header')</div>
    @endif
    <!-- Message Block ---------------------------->
    @if(Session::has('sms_error'))
        <div class="alert-box error"><span>error: </span>{{Session::get('sms_error')}}</div>
    @endif
    @if(Session::has('sms_warn'))
        <div class="alert-box warning"><span>warning: </span>{{Session::get('sms_warn')}}</div>
    @endif
    @if(Session::has('sms_success'))
        <div class="alert-box success"><span>success: </span>{{Session::get('sms_success')}}</div>
    @endif

    <div class="body">@yield('content')</div>
    @if(Auth::check())
            <div class="footer">@include('layout.footer')</div>
    @endif
    {{HTML::script('js/jquery1.11.js')}}
    {{HTML::script('js/menu.js')}}
    {{HTML::script('js/function.js')}}
    {{HTML::script('datepicker/jsDatePick.jquery.min.1.3.js')}}
   
    @yield('js')
    
</body>
</html>
