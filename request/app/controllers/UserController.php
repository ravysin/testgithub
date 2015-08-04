<?php
class UserController extends BaseController{
    public function _construct(){
        $this->beforeFilter(function(){
            
        });
    }
    public function getIndex(){
        $organize_list = $this->array_list(Organization::list_item());
        $department_list = $this->array_list(Department::list_item());
        $user_roll = $this->array_list(UserRoll::list_item());
        $organization = Input::has('organization')?Input::get('organization'):Auth::user()->employee->organization_id;
        $condition = " and org.id=" . $organization;
        $user_list = User::user_list($condition);
        return View::make('user.user', array(
            'organize_list'=>$organize_list,
            'department_list' =>$department_list,
            'organization'=>$organization,
            'user_list'=>$user_list,
            'user_roll' =>$user_roll,
        ));
    }
    public function postIndex(){
        $organize_list = $this->array_list(Organization::list_item());
        $department_list = $this->array_list(Department::list_item());
        $user_roll = $this->array_list(UserRoll::list_item());
        $organization = Input::get('organization');
        
        $condition = "";
        if(Input::has('em_name'))
            $condition .= " and em.en like '%" . Input::get('em_name') . "%'";
        if(Input::has('em_name_kh'))
            $condition .= " and em.kh like '%" . Input::get('em_name_kh') . "%'";
        if(Input::has('em_id'))
            $condition .= " and em.code='" . Input::get('em_id') . "'";
        if(Input::get('organization') > 0)
            $condition .= " and org.id=" . Input::get('organization');
        if(Input::get('department')>0)
            $condition .= " and de.id=" . Input::get('department');
        if(Input::get('user_roll') > 0)
            $condition .= " and ur.id=" . Input::get('user_roll');
            
        $user_list = User::user_list($condition);
        return View::make('user.user', array(
            'organize_list'=>$organize_list,
            'department_list' =>$department_list,
            'organization'=>$organization,
            'user_list'=>$user_list,
            'user_roll' =>$user_roll,
        ));
    }
    
    public function getNew(){
        $employee = $this->array_list(Employee::list_item());
        $user_roll = $this->array_list(UserRoll::list_item());
        return View::make('user.new', array(
            'employee'=>$employee,
            'user_roll' =>$user_roll,
        ));
    }
    public function postNew(){
        $employee = $this->array_list(Employee::list_item());
        $user_roll = $this->array_list(UserRoll::list_item());
        if(strlen(Input::get('user_name'))<4){
            Session::flash('sms_warn',trans('sta.user_min_5'));
        }elseif(strlen(Input::get('password'))<4){
            Session::flash('sms_warn',trans('sta.password_min_5'));
        }elseif(Input::get('password') != Input::get('confirm')){
            Session::flash('sms_warn',trans('sta.password_confirm_invalid'));
        }elseif(Input::get('employee')<=0){
            Session::flash('sms_warn',trans('sta.user_need_employee'));
        }elseif(input::get('user_roll')<=0){
            Session::flash('sms_warn',trans('sta.user_need_user_roll'));
        }elseif($this->is_employee_exist(Input::get('employee'))){
            Session::flash('sms_warn',trans('sta.employee_already_in_user'));
        }elseif($this->is_user_exist(Input::get('user_name'))){
            Session::flash('sms_warn', trans('sta.user_already_exist'));
        }else{
            $user = new User();
            $user->user = Input::get('user_name');
            $user->password = Hash::make(Input::get('password'));
            $user->employee_id = Input::get('employee');
            $user->user_roll_id = Input::get('user_roll');
            $user->created_by = Auth::user()->id;
            
            $user->save();
            
            $manage_organize = new ManageOrganization();
            $manage_organize->user_id = $user->id;
            $manage_organize->organization_id = Auth::user()->employee->organization_id;
            $manage_organize->created_by = Auth::user()->id;
            $manage_organize->save();
            
            return Redirect::to('user/edit/' . Crypt::encrypt($user->id));
        }
        
        return View::make('user.new', array(
            'employee'=>$employee,
            'user_roll' =>$user_roll,
        ));
    }
    
    public function getEdit($user_id){
        $user_id = Crypt::decrypt($user_id);
        $organize_list = $this->array_list(Organization::list_item());
        $user_roll = $this->array_list(UserRoll::list_item());
        $user = User::find($user_id);
        $manage_organization_list = ManageOrganization::manage_organization_list($user->id);
        
        return View::make('user.edit', array(
            'user_roll' =>$user_roll,
            'organization_list'=>$organize_list,
            'user'=>$user,
            'manage_organization_list'=>$manage_organization_list,
        ));
    }
    public function postEdit($user_id){
        $user_id = Crypt::decrypt($user_id);
        $user = User::find($user_id);
        if(Input::has('update')){
            if(strlen(Input::get('user_name'))<4){
                Session::flash('sms_warn',trans('sta.user_min_5'));
            }elseif(input::get('user_roll')<=0){
                Session::flash('sms_warn',trans('sta.user_need_user_roll'));
            }elseif($this->is_user_exist(Input::get('user_name')) && $user->user != Input::get('user_name')){
                Session::flash('sms_warn', trans('sta.user_already_exist'));
            }else{
                //$user = User::find($user_id);
                $user->user = Input::get('user_name');
                $user->user_roll_id = Input::get('user_roll');
                $user->updated_by = Auth::user()->id;
                $user->save();
            }    
        }elseif(Input::has('reset')){
            if(strlen(Input::get('password'))<4){
                Session::flash('sms_warn',trans('sta.password_min_5'));
            }elseif(Input::get('password') != Input::get('confirm')){
                Session::flash('sms_warn',trans('sta.password_confirm_invalid'));
            }else{
                $user->password = Hash::make(Input::get('password'));
                $user->updated_by = Auth::user()->id;
                $user->save();
            }
        }elseif(Input::has('add')){
            if(Input::get('organization')<=0){
                Session::flash('sms_warn', trans('sta.need_organization'));
            }elseif($this->is_organization_exist(Input::get('organization'), $user->id)){
                Session::flash('sms_warn', trans('sta.user_organization_exist'));
            }else{
                $manage_organize = new ManageOrganization();
                $manage_organize->user_id = $user->id;
                $manage_organize->organization_id = Input::get('organization');
                $manage_organize->created_by = Auth::user()->id;
                $manage_organize->save();
            }
        }
        
        
        
        $organize_list = $this->array_list(Organization::list_item());
        $user_roll = $this->array_list(UserRoll::list_item());
        
        $manage_organization_list = ManageOrganization::manage_organization_list($user->id);
        
        return View::make('user.edit', array(
            'user_roll' =>$user_roll,
            'organization_list'=>$organize_list,
            'user'=>$user,
            'manage_organization_list'=>$manage_organization_list,
        ));
    }
    
    public function getPassword(){
        return View::make('user.change_password');
    }
    public function postPassword(){
        $user = Auth::user();
        if(!Hash::check(Input::get('old_password'), $user->password)){
            Session::flash('sms_warn',trans('sta.old_password_incorrect'));
        }elseif(strlen(Input::get('new_password'))<4){
            Session::flash('sms_warn',trans('sta.password_min_5'));
        }elseif(Input::get('new_password') != Input::get('confirm')){
            Session::flash('sms_warn',trans('sta.password_confirm_invalid'));
        }else{
            $user->password = Hash::make(Input::get('new_password'));
            $user->updated_by = Auth::user()->id;
            $user->save();
            Session::flash('sms_success',trans('sta.save_success'));
        }
        return $this->getPassword();
    }
    
    public function getDelete($user_id){
        $user_id = Crypt::decrypt($user_id);
        $user = User::find($user_id);
        
        $user->is_deleted = 1;
        $user->updated_by = Auth::user()->id;
        $user->save();
        
        return Redirect::to('user');
    }
    
    public function getDelorganization($id){
        $id = Crypt::decrypt($id);
        $manage_organize = ManageOrganization::find($id);
        $manage_organize->is_deleted = 1;
        $manage_organize->updated_by = Auth::user()->id;
        $manage_organize->save();
         
        return Redirect::to('user/edit/' . Crypt::encrypt($manage_organize->user_id));
    }
    public function is_employee_exist($em_id){
        $user_list = User::user_id_by_em_id($em_id);
        if(sizeof($user_list)>0)
            return true;
        else
            return false;
    }
    public function is_user_exist($user_name){
        $user_list = User::user_id_by_name($user_name);
        if(sizeof($user_list)>0){
            return true;
        }else
            return false;
    }
    public function is_organization_exist($org_id, $user_id){
        $org_list = ManageOrganization::manage_organization_list_by_org_id($org_id, $user_id);
        if(sizeof($org_list)>0){
            return true;
        }else
            return false;
    }
    public static function set_permission(){
        $url_a = explode('/', Request::path());
        $result = "/" . $url_a[0];
        if(sizeof($url_a)>1 && $url_a[1]!="" ){
            $result .= "/" . $url_a[1];
        }
        $per_a = array('can_view'=>0,'can_add'=>0,'can_edit'=>0,'can_delete'=>0,'roll'=>'view');
        $permission_list = Permission::permission_by_url($result);
        foreach($permission_list as $per){
            if($per->allow_all==0){
                $per_a['can_view'] = $per->can_view;
                $per_a['can_add'] = $per->can_add;
                $per_a['can_edit'] = $per->can_edit;
                $per_a['can_delete'] = $per->can_delete;  
                $per_a['roll'] = $per->roll;  
            }else{
                $per_a = array('can_view'=>1,'can_add'=>1,'can_edit'=>1,'can_delete'=>1,'roll'=>'view');
            }
            
        }
        Session::flash('patm', $per_a);
        return $per_a;
    }
    public function getLangkh($url){
        Session::put('lang','kh');
        return Redirect::to(Crypt::decrypt($url));
    }
    public function getLangen($url){
        
        Session::put('lang','en');
        return Redirect::to(Crypt::decrypt($url));
    }
}



/*

*/
?>