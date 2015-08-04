@Extends('master')
@section('content')
<div class="box">
    <div class="head"></div>
    <div class="inner">
        {{Form::open()}}
            <div class="break">
                {{HTML::link('/unit/new', trans('var.new_unit'), array('class'=>'btnSubmit'))}} 
            </div>
        {{Form::close()}}
    </div>
</div>

<div class="table_tyle">
    <table>
        <thead>
            <tr>
                <th>{{trans('var.num')}}</th>
                <th>{{trans('var.unit')}}</th>
                <th>{{trans('var.description')}}</th>
                <th>{{trans('var.action')}}</th>
            </tr>
        </thead>
        <tbody>
          
        <?php $num = 1;?>
        @foreach($unitgets as $unitget)
            <tr> 
                <td>{{$num}}</td>
                <td>{{$unitget->name}}</td>
                <td>{{$unitget->description}}</td>
                <td>
                    {{HTML::link('/unit/deleteform/' . Crypt::encrypt($unitget->id), trans('var.delete'))}}
                </td>
            </tr>
            <?php $num += 1; ?>
        @endforeach
       
        </tbody>
    </table>
</div>
@endsection


