@Extends('master')
@section('content')
<head>
<script src="public/js/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="public/css/sweetalert.css">
</head>
<div class="box">
    <div class="head">{{trans('var.new_rstaff')}}</div>
    <div class="inner">
        {{Form::open()}}
            <div class="form_group">
                {{Form::label(trans('var.request_by'))}}
                {{Form::select('employee', $employees, Input::get('employee'))}}
                <strong>*</strong>
            </div>            
            
            <div class="break">
                {{Form::submit(trans('var.save'), array('name'=>'save', 'class'=>'btnSubmit'))}}
                <button onclick="myFunction()">Save</button>
            </div>
        {{Form::close()}}
    </div>
</div>
<script type="text/javascript">
    function myFunction(){
    swal("Good job!", "You clicked the button!", "success")
    };
</script>
@endsection