<?php

class StaffRequestController extends BaseController{
    //=== Index Page Staff Request ==
    public function getIndex(){
        $rstaffsgets=RStaff::getallrequeststaff();
        return View::make('request_staff.listallstaff',array('rstaffsgets'=>$rstaffsgets,));
        
    }

    //=== Open Page New Staff Request ==
    public function getNew(){
        $employees = $this->array_list(Employee::list_item());
        return View::make('request_staff.new',array(
            'employees'=>$employees
        ));
    }
    
    //=== Save New Staff Request ==
    public function postNew(){
        if(Input::has('save')){
            $getrstaffnew=Input::get('employee');
            if(Input::get('employee')==0){
                Session::flash('sms_error', trans('require_field'));
                return Redirect::to('request_staff/new');
            }
            else{
                $empid=DB::table('r_staffs')->Where('EmployeeID', $getrstaffnew)->first();

                if( $empid!=null && (int)$empid->EmployeeID==$getrstaffnew && (int)$empid->is_delete==1){
                    Session::flash('sms_warn', trans('sta.same_staff'));
                    return Redirect::to('request_staff/new');
                   
                }
                elseif( $empid!=null && (int)$empid->EmployeeID==$getrstaffnew && (int)$empid->is_delete==0){
                    $sql=array('is_delete'=>1);
                    $check=0;
                    $check=DB::table('r_staffs')->where('EmployeeID',$getrstaffnew)->update($sql);
                    if($check>0){
                        Session::flash('sms_success', trans('sta.save_data_success'));
                        return Redirect::to('request_staff');
                    }
                }
                else{      
                    $rstaffnew=new RStaff();
                    $rstaffnew->EmployeeID=$getrstaffnew;
                    $rstaffnew->is_delete=1;
                    //$rstaffnew->created_by=Auth::user()->employee_id;;
                    $rstaffnew->created_at=date('Y-m-d');
                    // $rstaffnew->updated_by=Auth::user()->employee_id;;
                    $rstaffnew->updated_at=date('Y-m-d');
                    if($rstaffnew->save()){
                        Session::flash('sms_success', trans('sta.save_data_success'));
                        return Redirect::to('request_staff');
                    }
                
                } 
            } 
        }
    }

    //=== Edit is_delete=0 when click delete ==
    public function getDeleteform($id){
        $rstaffdelete=new RStaff();
        $rstaffdelete=RStaff::find($id);
        $rstaffdelete->is_delete=0;
        if($rstaffdelete->save()){
            return Redirect::to('request_staff');
        }
        /*$sql=array('is_delete'=>0);
        $check=0;
        $check=DB::table('r_staffs')->where('EmployeeID',$id)->update($sql);
        if($check>0){
            Session::flash('sms_success', trans('sta.save_data_success'));
            return Redirect::to('request_staff');
        }*/
    }
}


?>