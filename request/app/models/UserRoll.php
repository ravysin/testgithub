<?php
class UserRoll extends Eloquent {
    protected function user(){
        return $this->hasMany('User');
    }
    public static function list_item(){
        $lang = Config::get('app.locale');
        $sql = "SELECT ur.id AS id, ur.$lang AS label
                FROM user_rolls AS ur
                WHERE ur.is_deleted=0";
        return DB::select($sql);
    }
    protected function user_roll_list(){
        $sql = "SELECT * FROM user_rolls AS ur WHERE ur.is_deleted=0";
        return DB::select($sql);
    }
}
