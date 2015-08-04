@Extends('edit_request')
@section('sub_block')
<div class="box" style="max-width: 1000px;">
    <div class="head">{{trans('var.edit_form')}}</div>
    <div class="inner">
        {{Form::open()}}
            <div class="form_group">
                {{Form::label(trans('var.request_by'))}}
                {{Form::select('employee', $employees, $request->request_by_id)}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.for_organization'))}}
                {{Form::select('organization', $organizations, $request->for_organization_id)}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.for_plan'))}}
                {{Form::select('r_plan', $r_plans, $request->for_planning_id)}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.to_specialist'))}}
                {{Form::select('specialist', $specialist, $request->to_department_id)}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.request_title'))}}
                {{Form::text('title', $request->request_title)}}
                <strong>*</strong>
            </div>
            <div class="form_group">
                {{Form::label(trans('var.description'))}}
                {{Form::textarea('description', $request->description)}}
                <strong title="">*</strong>
            </div>
            
            <div class="break">
                {{Form::submit(trans('var.save'), array('name'=>'save', 'class'=>'btnSubmit'))}}
                {{HTML::link('/branch_request', trans('var.cancel'), array('class'=>'btnReset'))}}
            </div>
        {{Form::close()}}
    </div>
</div>

@endsection