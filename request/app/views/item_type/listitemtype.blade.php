@Extends('master')
@section('content')
<div class="box">
    <div class="head"></div>
    <div class="inner">
        {{Form::open()}}
            <div class="break">
                {{HTML::link('/itemtype/new', trans('var.new_itemtype'), array('class'=>'btnSubmit'))}} 
            </div>
        {{Form::close()}}
    </div>
</div>

<div class="table_tyle">
    <table>
        <thead>
            <tr>
                <th>{{trans('var.num')}}</th>
                <th>{{trans('var.itemtype')}}</th>
                <th>{{trans('var.description')}}</th>
                <th>{{trans('var.action')}}</th>
            </tr>
        </thead>
        <tbody>
        
        <?php $num = 1;?>
        @foreach($itemtypegets as $itemtypeget)
            <tr> 
                <td>{{$num}}</td>
                <td>{{$itemtypeget->name}}</td>
                <td>{{$itemtypeget->description}}</td>
              
                <td>
                    {{HTML::link('/itemtype/deleteform/' . Crypt::encrypt($itemtypeget->id), trans('var.delete'))}}
                </td>
            </tr>
            <?php $num += 1; ?>
        @endforeach
       
        </tbody>
    </table>
</div>
@endsection


