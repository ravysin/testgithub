<?php
class BranchRequestController extends BaseController{
    
    public function _construct(){
        $this->beforeFilter(function(){
            
        });
    }
    
    public function getIndex(){
        $requests = RRequest::request_list();
        return View::make('branch_request.list',array(
            'requests'=>$requests,
        ));
    }
    public function getNew(){
        $organizations = $this->array_list(Organization::list_item());
        $employees = $this->array_list(Employee::list_item());
        $department = $this->array_list(Department::list_item());
        $r_plans = $this->array_list(Rplan::list_item());
        return View::make('branch_request.new',array(
            'organizations'=>$organizations,
            'employees'=>$employees,
            'specialist'=>$department,
            'r_plans'=>$r_plans
        ));
    }
    public function postNew(){
        if(Input::has('save')){
            if(Input::get('employee')==0 
            || Input::get('organization')==0
            || Input::get('r_plan')==0 
            || Input::get('specialist')==0
            || strlen(Input::get('title'))<2
            || strlen(Input::get('description'))<2){
                Session::flash('sms_warn', trans('sta.require_field'));
            }else{
                $request = new RRequest();
                $request->request_by_id = Input::get('employee');
                $request->for_organization_id = Input::get('organization');
                $request->for_planning_id = Input::get('r_plan');
                $request->to_department_id = Input::get('specialist');
                $request->request_title = Input::get('title');
                $request->description = Input::get('description');
                
                $request->request_date = date('Y-m-d');
                $request->created_by = Auth::user()->employee_id;
                
                if($request->save()){
                    Session::flash('sms_success', trans('sta.save_data_success'));
                    return Redirect::to('branch_request/general/' . Crypt::encrypt($request->id));
                }
            }
        }
        $organizations = $this->array_list(Organization::list_item());
        $employees = $this->array_list(Employee::list_item());
        $department = $this->array_list(Department::list_item());
        $r_plans = $this->array_list(Rplan::list_item());
        return View::make('branch_request.new',array(
            'organizations'=>$organizations,
            'employees'=>$employees,
            'specialist'=>$department,
            'r_plans'=>$r_plans
        ));
    }
    public function getGeneral($id){
        $id = Crypt::decrypt($id);
        $request = RRequest::find($id);
        $organizations = $this->array_list(Organization::list_item());
        $employees = $this->array_list(Employee::list_item());
        $department = $this->array_list(Department::list_item());
        $r_plans = $this->array_list(Rplan::list_item());
        return View::make('branch_request.edit_general', array(
            'id' => $id,
            'organizations'=>$organizations,
            'employees'=>$employees,
            'specialist'=>$department,
            'r_plans'=>$r_plans,
            'request'=>$request,
        ));
    }
    public function postGeneral($id){
        $id = Crypt::decrypt($id);
        $request = RRequest::find($id);
        if(Input::has('save')){
            if(Input::get('employee')==0 
            || Input::get('organization')==0
            || Input::get('r_plan')==0 
            || Input::get('specialist')==0
            || strlen(Input::get('title'))<2
            || strlen(Input::get('description'))<2){
                Session::flash('sms_warn', trans('sta.require_field'));
            }else{
                $request->request_by_id = Input::get('employee');
                $request->for_organization_id = Input::get('organization');
                $request->for_planning_id = Input::get('r_plan');
                $request->to_department_id = Input::get('specialist');
                $request->request_title = Input::get('title');
                $request->description = Input::get('description');
                
                $request->request_date = date('Y-m-d');
                $request->created_by = Auth::user()->employee_id;
                
                if($request->save()){
                    Session::flash('sms_success', trans('sta.save_data_success'));
                    //return Redirect::to('branch_request/general/' . Crypt::encrypt($request->id));
                }
            }
        }
        $organizations = $this->array_list(Organization::list_item());
        $employees = $this->array_list(Employee::list_item());
        $department = $this->array_list(Department::list_item());
        $r_plans = $this->array_list(Rplan::list_item());
        return View::make('branch_request.edit_general', array(
            'id' => $id,
            'organizations'=>$organizations,
            'employees'=>$employees,
            'specialist'=>$department,
            'r_plans'=>$r_plans,
            'request'=>$request,
        ));
    }
    public function getSound($id){
        $id = Crypt::decrypt($id);
        $request = RRequest::find($id);
        return View::make('branch_request.edit_sound', array(
            'id'=>$id,
            'request'=>$request,
        ));
    }
    public function postSound($id){
        $id = Crypt::decrypt($id);
        $request = RRequest::find($id);
        // Save image if exist
            if(Input::hasFile('sound')){
                $sound_name = time() . Auth::user()->id . "." . Input::file('sound')->getClientOriginalExtension();
                echo "<h1>Found sound</h1>";
                Input::file('sound')->move('sounds/', $sound_name);
                $request->voice_reading = $sound_name;
                $request->save();
            }else{
                echo "<h1>File not found</h1>";
            }
        return View::make('branch_request.edit_sound', array(
            'id'=>$id,
            'request'=>$request,
        ));
    }
    public function getFile($id){
        $id = Crypt::decrypt($id);
        $request = RRequest::find($id);
        return View::make('branch_request.edit_file', array(
            'id'=>$id,
            'request'=>$request,
        ));
    }
    public function postFile($id){
        $id = Crypt::decrypt($id);
        $request = RRequest::find($id);
        // Save image if exist
            if(Input::hasFile('sound')){
                $sound_name = time() . Auth::user()->id . "." . Input::file('sound')->getClientOriginalExtension();
                echo "<h1>Found sound</h1>";
                Input::file('sound')->move('sounds/', $sound_name);
                $request->voice_reading = $sound_name;
                $request->save();
            }else{
                echo "<h1>File not found</h1>";
            }
        return View::make('branch_request.edit_file', array(
            'id'=>$id,
            'request'=>$request,
        ));
    }
}
?>