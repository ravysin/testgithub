<!doctype html>
<head>
    <?php $lang = Config::get('app.locale'); ?>
	<meta charset="UTF-8"/>
	<title>Human Resources Management</title>
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
    <div class="body">@yield('content')</div>
    {{HTML::script('js/jquery1.11.js')}}
    {{HTML::script('js/menu.js')}}
    {{HTML::script('js/function.js')}}
    {{HTML::script('datepicker/jsDatePick.jquery.min.1.3.js')}}
    @yield('js')
</body>
</html>
