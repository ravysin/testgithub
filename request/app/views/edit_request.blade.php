@Extends('master')
@section('content')
<div class="sub_block_left">
    <div class="sub_menu1">
        <?php
        $sub_menu_list = User::get_menu_list(61,14);
        if(sizeof($sub_menu_list)>0){
            foreach($sub_menu_list as $sub_menu){
                ?>
                <li>{{HTML::link($sub_menu->link . '/' . Crypt::encrypt($id),$sub_menu->menu,array('target'=>$sub_menu->target))}}</li>
                <?php
            }
        }
        ?>
    </div>
</div>
<div class="sub_block_right">
    @yield('sub_block')
</div>
@endsection