@Extends('master')
@section('content')
<div class="box">
    <div class="head">{{trans('var.new_request')}}</div>
    <div class="inner">
        {{Form::open()}}
            <div class="form_group">
                {{Form::label(trans('var.request_by'))}}
                {{Form::select('employee', $employees, Input::get('employee'))}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.for_organization'))}}
                {{Form::select('organization', $organizations, Input::get('organization'))}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.for_plan'))}}
                {{Form::select('r_plan', $r_plans, Input::get('r_plan'))}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.to_specialist'))}}
                {{Form::select('specialist', $specialist, Input::get('specialist'))}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.request_title'))}}
                {{Form::text('title', Input::get('title'))}}
                <strong>*</strong>
            </div>
            <div class="form_group">
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