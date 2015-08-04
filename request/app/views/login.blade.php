@Extends('master')
@section('content')
<div class="login_contaner">
<center>
    {{HTML::image('images/logo-tp.png')}}
</center> 
<div class="box" style="width: 500px;">
    <div class="head">{{trans('var.login_form')}}</div>
    <div class="inner">
        
        {{Form::open()}}
            <input type="hidden" name="user_id" value="1"/>
            <div class="form_group">
                {{Form::label('info',trans('var.user_name'))}}
                {{Form::text('user')}}
            </div>
            <div class="form_group">
                {{Form::label('info',trans('var.password'))}}
                {{Form::password('password')}}
            </div>
            <div class="break">
                {{Form::submit(trans('submit'),array('class'=>'btnSubmit', 'name'=>'login'))}}
            </div>        
        {{Form::close()}}
        
    </div>
</div>
</div>
@endsection
