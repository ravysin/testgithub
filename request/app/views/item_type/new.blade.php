@Extends('master')
@section('content')
<head>
<script src="public/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/css/sweetalert.css">
</head>
<div class="box">
    <div class="head">{{trans('var.new_itemtype')}}</div>
    <div class="inner">
        {{Form::open()}}
            <div class="form_group">
                {{Form::label(trans('var.itemtype'))}}
                {{Form::text('itemtype', Input::get('itemtype'))}}
                <strong>*</strong>
                {{Form::label(trans('var.description'))}}
                {{Form::textarea('description', Input::get('description'))}}
                <strong title="">*</strong>
            </div>      
            <div class="break">
                {{Form::submit(trans('var.save'), array('name'=>'save', 'class'=>'btnSubmit'))}} 
            </div>
        {{Form::close()}}
    </div>
</div>

@endsection