<?php
class RRequestDetail extends Eloquent{

    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "SELECT tt.id as id, tt.$lang as label
                FROM r_item_types as tt 
                WHERE 1=1 
                order by label";
        return DB::select($sql);
    }
    public static function data_list($id){
        $sql = "select rd.id, rd.item_name, it.en as item_type, un.en as unit, 
                rd.quantity, rd.estimate_price, rd.description, rd.modify_by
                from (r_request_details as rd left join r_item_types as it on rd.request_id=it.id)
                left join r_units as un on rd.unit_id=un.id
                where rd.is_deleted = 0 and rd.request_id = $id";
        return DB::select($sql);
    }
    
    
}
?>