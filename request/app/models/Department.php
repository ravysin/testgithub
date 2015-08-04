<?php
class Department extends Eloquent{
    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "SELECT departments.id as id, departments.$lang as label
                FROM departments WHERE departments.is_deleted=0 
                order by departments.$lang";
        return DB::select($sql);
    }
}
?>