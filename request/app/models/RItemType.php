<?php
class RItemType extends Eloquent{

    public static function get_allItemtype(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        return DB::table('r_item_types as it')
        		   ->select('it.id as id','it.en as name','it.description as description')
        		   ->orderBy('it.en')
        		   ->get();
    }
}
?>