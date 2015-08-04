<?php

class PlanController extends BaseController{
    //=== Index Page Plan ===
    public function getIndex(){
        $plangets=RPlan::get_allplan();
        return View::make('plan.listplan',array('plangets'=>$plangets,));     
    }
    //=== Get New Form to New Plan ===
    public function getNew(){
        return View::make('plan.new');
    }
    //=== Post New Form to Save New Plan ===
    public function postNew(){
        if(Input::has('save')){
            if(strlen(Input::get('plan'))<2){
                Session::flash('sms_warn', trans('require_field'));
                return Redirect::to('plan/new');
            }else{
                $plannew=new RPlan();
                $plannew->en=Input::get('plan');
                $plannew->description=Input::get('description');
                $plannew->created_by=Auth::user()->id;

                if($plannew->save()){
                    Session::flash('sms_success', trans('sta.save_data_success'));
                    return Redirect::to('plan');
                }
            }
        }
    }
    //=== Get ID to Delete from table Plan ===
    public function getDeleteform($id){
        $id = Crypt::decrypt($id);
        $plandelete=RPlan::find($id);
        if($plandelete->delete()){
            Session::flash('sms_success', trans('sta.save_data_success'));
            return Redirect::to('plan');
        }
    }

}


?>