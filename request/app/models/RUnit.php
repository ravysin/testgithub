<?php
class RUnit extends Eloquent{

    public static function get_allUnit(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        return DB::table('r_units as un')
        		   ->select('un.id as id','un.en as name','un.description as description')
        		   ->orderBy('un.en')
        		   ->get();
    }
}
?>