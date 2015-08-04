<?php
class Organization extends Eloquent{
    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "SELECT organizations.id as id, organizations.$lang as label
                FROM organizations 
                ORDER BY organizations.$lang";
        return DB::select($sql);
    }
}
?>