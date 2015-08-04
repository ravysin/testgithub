<?php
class Employee extends Eloquent{

    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "SELECT tt.id as id, tt.$lang as label
                FROM r_item_types as tt 
                WHERE 1=1 
                order by label";
        return DB::select($sql);
    }
    
    
}
?>