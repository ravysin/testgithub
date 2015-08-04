<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');
    
    protected function employee(){
		return $this->belongsTo('Employee');
	}
    
    protected function get_menu_list($module_id, $level = 1){
        $lang = Config::get('app.locale');
        $user_roll = Auth::user()->user_roll_id;
        $condition = "";
        if($module_id>0)
            $condition = " AND  menus.parent_menu_id = $module_id ";
        $sql="SELECT DISTINCT menus.id, menus.$lang AS menu, links.link, menus.target 
            FROM (((menus LEFT JOIN links ON menus.link_id = links.id)
                LEFT JOIN modules ON links.module_id=modules.id) 
                LEFT JOIN permissions ON modules.id = permissions.module_id)
            WHERE menus.level=$level AND permissions.user_roll_id=$user_roll $condition AND 
                ((links.roll='view' AND permissions.can_view=1) OR (links.roll='add' AND permissions.can_add=1) 
                OR (links.roll='edit' AND permissions.can_edit=1) OR (links.roll='delete' AND permissions.can_delete=1) 
                OR links.allow_all = 1) order by menus.order ";
        //if($module_id==24) echo $sql;
        $menu_list = DB::select($sql);
        return $menu_list;
    }
    
    protected function user_list($condition = ""){
        $lang = Config::get('app.locale');
        $user_id = Auth::user()->id;
        $sql = "SELECT us.id, em.code AS em_code, em.$lang AS em_name, org.$lang as organization, de.$lang as department, 
                us.user, '****************' AS pw, ur.$lang as user_roll, ifnull(DATE_FORMAT(us.updated_at,'%m-%d-%Y %h:%i %p'),DATE_FORMAT(us.created_at,'%m-%d-%Y %h:%i %p')) AS modify_at
                FROM ((((users AS us LEFT JOIN employees AS em ON us.employee_id=em.id)
                LEFT JOIN user_rolls AS ur ON us.user_roll_id=ur.id)
                left join organizations as org on em.organization_id=org.id)
                left join departments as de on em.department_id=de.id)
                WHERE us.is_deleted = 0 
                AND em.organization_id IN (SELECT manage_organizations.organization_id FROM manage_organizations WHERE manage_organizations.is_deleted = 0 AND manage_organizations.is_deleted = 0 AND manage_organizations.user_id=$user_id) 
                $condition  
                ORDER BY em.$lang"; 
                
        return DB::select($sql);
    }
    
    protected function user_id_by_em_id($em_id){
        $sql = "SELECT us.id from users as us where us.is_deleted=0 and us.employee_id=" . $em_id; 
        return DB::select($sql);
    }
    protected function user_id_by_name($user_name){
        $sql = "SELECT us.id from users as us where us.is_deleted=0 and us.user='" . $user_name . "'"; 
        return DB::select($sql);
    }
}
