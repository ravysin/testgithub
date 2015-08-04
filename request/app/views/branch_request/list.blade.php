@Extends('master')
@section('content')
<div class="box">
    <div class="head"></div>
    <div class="inner">
        {{Form::open()}}
            <div class="break">
                {{HTML::link('/branch_request/new', trans('var.new_request'), array('class'=>'btnSubmit'))}}
            </div>
        {{Form::close()}}
    </div>
</div>

<div class="table_tyle">
    <table>
        <thead>
            <tr>
                <th>{{trans('var.num')}}</th>
                <th>{{trans('var.requester')}}</th>
                <th>{{trans('var.for_branch')}}</th>
                <th>{{trans('var.for_plan')}}</th>
                <th>{{trans('var.specialist')}}</th>
                <th>{{trans('var.title')}}</th>
                <th>{{trans('var.request_date')}}</th>
                <th>{{trans('var.summary')}}</th>
                <th>{{trans('var.action')}}</th>
            </tr>
        </thead>
        <tbody>
        <?php $num = 1; ?>
        @foreach($requests as $request)
            <tr>
                <td>{{$num}}</td>
                <td>{{$request->em_name}}</td>
                <td>{{$request->organization}}</td>
                <td>{{$request->plan}}</td>
                <td>{{$request->department}}</td>
                <td>{{$request->request_title}}</td>
                <td>{{$request->request_date}}</td>
                <td>{{$request->description}}</td>
                <td>{{HTML::link('/branch_request/general/' . Crypt::encrypt($request->id), trans('var.edit'))}}</td>
            </tr>
            <?php $num += 1; ?>
        @endforeach
        </tbody>
    </table>
</div>
@endsection