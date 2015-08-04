<?php
class Employee extends Eloquent{
    protected $rows = 20;
    protected function user(){
        return $this->hasMany('User');
    }
    public static function list_item(){
        $user_id = Auth::user()->id;
        $lang = Config::get('app.locale');
        $sql = "SELECT employees.id as id, CONCAT(employees.$lang, ' (',employees.code, ')') as label
                FROM employees WHERE is_deleted=0 and 
                employees.organization_id IN (SELECT manage_organizations.organization_id FROM manage_organizations WHERE manage_organizations.is_deleted = 0 AND manage_organizations.user_id=$user_id) 
                order by employees.$lang";
        return DB::select($sql);
    }
    
    protected function employee_list($condition = "", $order = ""){
        $lang = Config::get('app.locale');
        $user_id = Auth::user()->id;
        
        if($order == ""){
            $order = "ORDER BY employees.id DESC LIMIT " . $this->rows;
        }
        
        $sql = "SELECT employees.id, employees.code, employees.$lang AS em_name, genders.$lang AS gender, employees.photo, 
        DATE_FORMAT(employees.dob,'%d-%m-%Y') as dob,  nationalities.$lang as nationality, 
         employees.salary+employees.phone_fee+employees.gasoline_fee+employees.food_fee AS benefit, 
        organizations.$lang AS organization, employees.address,
        departments.id as department_id, departments.$lang as department, positions.$lang AS `position`, employees.telephone, employees.email, 
        levels.$lang as level, DATE_FORMAT(employees.end_date,'%d-%m-%Y') as end_date , DATE_FORMAT(employees.start_date,'%d-%m-%Y') as start_date  
        FROM (((((employees LEFT JOIN genders ON employees.gender_id=genders.id)
        LEFT JOIN organizations ON employees.organization_id=organizations.id)
        LEFT JOIN departments ON employees.department_id=departments.id)
        LEFT JOIN positions ON employees.position_id=positions.id)
        LEFT JOIN levels ON employees.level_id=levels.id)
        LEFT JOIN nationalities ON employees.nationality_id=nationalities.id
        WHERE employees.is_deleted=0 $condition 
        AND employees.organization_id IN (SELECT manage_organizations.organization_id FROM manage_organizations WHERE manage_organizations.is_deleted = 0 AND manage_organizations.user_id=$user_id) " 
        . $order;
        return DB::select($sql);
    }
    
    protected function search_employee(){
        $lang = Config::get('app.locale');
        $user_id = Auth::user()->id;
        $condition = "";
        
        if(Input::has('em_name')){
            $condition .= " and employees.en like '%" . Input::get('em_name') . "%'";
        }
        if(Input::has('em_name_kh')){
            $condition .= " and employees.kh like '%" . Input::get('em_name_kh') . "%'";
        }
        if(Input::has('em_id')){
            $condition .= " and employees.code like '%" . Input::get('em_id') . "%'";
        }
        if(Input::get('gender')>0){
            $condition .= " and employees.gender_id = " . Input::get('gender');
        }
        if(Input::get('organization')>0){
            $condition .= " and employees.organization_id = " . Input::get('organization');
        }
        if(Input::get('department')>0){
            $condition .= " and employees.department_id in(" . Input::get('h_department') . ")";
        }
        if(Input::get('position')>0){
            $condition .= " and employees.position_id = " . Input::get('position');
        }
        if(Input::get('employee_type')>0){
            $condition .= " and employees.employee_type_id = " . Input::get('employee_type');
        }
        if(Input::get('employee_status')>0){
            $condition .= " and employees.employee_status_id = " . Input::get('employee_status');
        }
        if(Input::get('level')>0){
            $condition .= " and employees.level_id = " . Input::get('level');
        }
        
        $order = " ORDER BY employees.id DESC";
        if(Input::get('order')!='0'){
            if(Input::get('order') == 'department'){
                $order = " ORDER BY departments.order, employees.level_id ";
            }else{
                $order = " ORDER BY employees." . Input::get('order');
            }
        }
        $sql = "SELECT employees.id, employees.code, employees.$lang AS em_name, genders.$lang AS gender, organizations.$lang AS organization, 
        departments.id as department_id, departments.$lang as department, positions.$lang AS `position`, employees.telephone, employees.email, 
        levels.$lang as level, DATE_FORMAT(employees.end_date,'%d-%m-%Y') as end_date , DATE_FORMAT(employees.start_date,'%d-%m-%Y') as start_date 
        FROM ((((employees LEFT JOIN genders ON employees.gender_id=genders.id)
        LEFT JOIN organizations ON employees.organization_id=organizations.id)
        LEFT JOIN departments ON employees.department_id=departments.id)
        LEFT JOIN positions ON employees.position_id=positions.id)
        LEFT JOIN levels ON employees.level_id=levels.id
        WHERE employees.is_deleted=0 
        AND employees.organization_id IN (SELECT manage_organizations.organization_id FROM manage_organizations WHERE manage_organizations.is_deleted = 0 AND manage_organizations.user_id=$user_id)" . 
        $condition
        . $order;
        return DB::select($sql);
    }
    protected function employee_payroll_id($organization){
        $user_id = Auth::user()->id;
        $sql = "SELECT em.id
            FROM employees AS em
            WHERE em.is_deleted=0 AND em.employee_status_id=1 AND
            em.organization_id IN (SELECT manage_organizations.organization_id FROM manage_organizations WHERE manage_organizations.is_deleted = 0 AND manage_organizations.user_id=$user_id)
            AND em.organization_id=" . $organization;
            //echo $sql;
        return DB::select($sql);
    }
    protected function employee_payroll($em_id){
        $user_id = Auth::user()->id;
        $sql = "SELECT em.id, em.employee_type_id, em.organization_id, em.department_id, em.budget_id, 
            em.family_status_id, em.number_child, em.account_number, em.salary, em.monthly_bonus, em.food_fee, em.phone_fee, em.gasoline_fee
            FROM employees AS em
            WHERE em.is_deleted=0 AND em.employee_status_id=1 AND
            em.organization_id IN (SELECT manage_organizations.organization_id FROM manage_organizations WHERE manage_organizations.is_deleted = 0 AND manage_organizations.user_id=$user_id)
            AND em.id=" . $em_id . " LIMIT 1";
        return DB::select($sql);
    }
}
?>