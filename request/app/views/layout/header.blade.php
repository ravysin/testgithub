<table width="100%"><tr>
<td>{{HTML::image('images/logo-tp.png', '', array('class'=>'logo'))}}</td>
<td align="right" valign="bottom">
    <div class="language">
        <a href="{{URL::to('/user/langkh/' . Crypt::encrypt(Request::path()))}}">{{HTML::image('images/kh_flage.png', '', array('class'=>'lang'))}}</a>
        <a href="{{URL::to('/user/langen/' . Crypt::encrypt(Request::path()))}}">{{HTML::image('images/en_flage.png', '', array('class'=>'lang'))}}</a>
    </div>
    <div class="user">Welcom: {{Auth::user()->employee->en}}</div>
    <div class="logout">{{HTML::link('/user/password',trans('var.change_password'))}}</div>
    <div class="logout">{{HTML::link('logout',trans('var.logout'))}}</div>
</td>
</tr></table>
<div id='cssmenu'>
    <ul>
    <?php
        $module_list = User::get_menu_list(0,11);
        foreach($module_list as $module){
            ?>
            <li>{{HTML::link($module->link,$module->menu)}}
            <?php
            $menu_list = User::get_menu_list($module->id,12);
            if(sizeof($menu_list)>0){ ?><ul><?php
                foreach($menu_list as $menu){
                    ?>
                    <li>{{HTML::link($menu->link,$menu->menu)}}
                    <?php
                    $sub_menu_list = User::get_menu_list($menu->id,13); 
                    if(sizeof($sub_menu_list)>0){ ?><ul><?php 
                        foreach($sub_menu_list as $sub_menu){ 
                            ?>
                            <li>{{HTML::link($sub_menu->link,$sub_menu->menu)}}</li><?php
                        }
                        ?></ul><?php
                    }
                    
                    ?>
                    </li><?php
                }
                ?></ul><?php
            }
            
            ?></li><?php
        }
    ?>
    </ul>
</div>