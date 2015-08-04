@Extends('edit_request')
@section('sub_block')
<div class="box" style="max-width: 1000px;">
    <div class="head">{{trans('var.edit_form')}}</div>
    <div class="inner">
        {{Form::open(array('files'=>true))}}
           <div class="form_group">
                {{Form::label(trans('var.sound'))}}
                {{Form::file('sound')}}
            </div>
            <div class="break">
                {{Form::submit(trans('var.save'),array('class'=>'btnSubmit'))}}
                {{HTML::link('/branch_request', trans('var.cancel'), array('class'=>'btnReset'))}}
            </div>
        {{Form::close()}}
        <div class="break" style="margin-top: 20px;">
            <audio controls>
              <source src="{{asset('sounds' . '/' . $request->voice_reading)}}" type="audio/mpeg"/>
              {{trans('sta.browser_not_support_audio')}}
            </audio> 
        </div>
    </div>
</div>
@endsection