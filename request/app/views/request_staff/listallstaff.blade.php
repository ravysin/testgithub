@Extends('master')
@section('content')
<div class="box">
    <div class="head"></div>
    <div class="inner">
        {{Form::open()}}
            <div class="break">
                {{HTML::link('/request_staff/new', trans('var.new_rstaff'), array('class'=>'btnSubmit'))}} 
            </div>
        {{Form::close()}}
    </div>
</div>

<div class="table_tyle">
    <table>
        <thead>
            <tr>
                <th>{{trans('var.num')}}</th>
                <th>{{trans('var.staff_name')}}</th>
                <th>{{trans('var.gender')}}</th>
                <th>{{trans('var.position')}}</th>
                <th>{{trans('var.departement')}}</th>
                <th>{{trans('var.organization')}}</th>
                <th>{{trans('var.phone')}}</th>
                <th>{{trans('var.action')}}</th>
            </tr>
        </thead>
        <tbody>
        
        <?php $num = 1;
        
         ?>
        @foreach($rstaffsgets as $rstaffsget)
            <tr> 
                <td>{{$num}}</td>
                <td>{{$rstaffsget->emp_eng}}</td>
                <td>{{$rstaffsget->gen_en}}</td>
                <td>{{$rstaffsget->pos_en}}</td>
                <td>{{$rstaffsget->dep_en}}</td>
                <td>{{$rstaffsget->org_en}}</td>
                <td>{{$rstaffsget->telephone}}</td>
                <td>
                    <a href="<?=URL::to('/request_staff/deleteform',array($rstaffsget->id))?>"> 
                       {{ Form::button('<i class="glyphicon glyphicon-trash"></i> Delete', array('class' => 'btn btn-danger'))}}
                    </a>
                </td>
            </tr>
            <?php $num += 1; ?>
        @endforeach
       
        </tbody>
    </table>
</div>
@endsection


