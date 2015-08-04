<?php
class RRequest extends Eloquent{
    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "";
        return DB::select($sql);
    }
    public static function request_list(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "select re.id, em.en as em_name, org.en as organization, pl.en as plan, de.en as department, 
                re.request_title, re.description, re.request_date, re.voice_reading
                from ((((r_requests as re left join employees as em on re.request_by_id=em.id)
                left join organizations as org on re.for_organization_id=org.id)
                left join r_plans as pl on re.for_planning_id=pl.id)
                left join departments as de on re.to_department_id=de.id)";
        return DB::select($sql);
    }
    
    
}
?>