<?php
class Permission extends Eloquent{
    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "";
        return DB::select($sql);
    }
    protected function permission_roll($roll_id){
        $sql = "SELECT pe.id, me.id as menu_id, me.en, me.kh, me.description, pe.can_view, pe.can_add, pe.can_edit, pe.can_delete
                FROM permissions AS pe LEFT JOIN modules AS me ON pe.module_id=me.id
                WHERE pe.user_roll_id = " . $roll_id . " order by me.en";
        return DB::select($sql);
    }
    protected function un_menu($user_roll){
        $sql = "SELECT me.id FROM modules AS me
                WHERE me.id NOT IN (SELECT pe.module_id FROM permissions AS pe WHERE pe.user_roll_id = $user_roll)";
        return DB::select($sql);
    }
    protected function menu_list($userroll_id){
        $sql = "SELECT pe.id, me.id AS menu_id
                FROM permissions AS pe LEFT JOIN modules AS me ON pe.module_id=me.id 
                WHERE pe.user_roll_id = $userroll_id";
        return DB::select($sql);
    }
    protected function permission_by_url($url){
        $roll_id = Auth::user()->user_roll_id;
        $sql = "SELECT pe.id, me.en AS menu, pe.can_view, pe.can_add, pe.can_edit, pe.can_delete, li.link, li.allow_all, li.roll
                FROM ((permissions AS pe LEFT JOIN modules AS mo ON pe.module_id=mo.id)
                LEFT JOIN links AS li ON mo.id=li.module_id)
                LEFT JOIN menus AS me ON li.id=me.link_id
                WHERE ((li.roll='view' AND pe.can_view=1) OR (li.roll='add' AND pe.can_add=1) 
                OR (li.roll='edit' AND pe.can_edit=1) OR (li.roll='delete' AND pe.can_delete=1) OR li.allow_all = 1) 
                AND li.link LIKE '$url' AND pe.user_roll_id=$roll_id  LIMIT 1";
        return DB::select($sql);
    }
}
?>