@Extends('master')
@section('content')
<div class="box">
    <div class="head"></div>
    <div class="inner">
        {{Form::open()}}
            <div class="break">
                {{HTML::link('/plan/new', trans('var.new_plan'), array('class'=>'btnSubmit'))}} 
            </div>
        {{Form::close()}}
    </div>
</div>

<div class="table_tyle">
    <table>
        <thead>
            <tr>
                <th>{{trans('var.num')}}</th>
                <th>{{trans('var.plan')}}</th>
                <th>{{trans('var.description')}}</th>
                <th>{{trans('var.action')}}</th>
            </tr>
        </thead>
        <tbody>
        
        <?php $num = 1;?>
        @foreach($plangets as $planget)
            <tr> 
                <td>{{$num}}</td>
                <td>{{$planget->name}}</td>
                <td>{{$planget->description}}</td>
              
                <td>
                    {{HTML::link('/plan/deleteform/' . Crypt::encrypt($planget->id), trans('var.delete'))}}
                </td>
            </tr>
            <?php $num += 1; ?>
        @endforeach
       
        </tbody>
    </table>
</div>
@endsection


