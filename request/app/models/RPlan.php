<?php
class RPlan extends Eloquent{
    public static function get_allplan(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        return DB::table('r_plans as pn')
            	   ->select('pn.id as id','pn.en as name','pn.description as description')
            	   ->orderBy('pn.en')
                   ->get();
    } 
}
?>