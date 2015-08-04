<?php

class UnitController extends BaseController{
    //=== Index Page Unit ===
    public function getIndex(){
        $unitgets=RUnit::get_allUnit();
        return View::make('unit.listunit',array('unitgets'=>$unitgets,));     
    }
    //=== Get New Form to New Unit ===
    public function getNew(){
        return View::make('unit.new');
    } 
    //=== Post New Form to Save New Unit ===
    public function postNew(){
        if(Input::has('save')){
            if(strlen(Input::get('unit'))<2){
                Session::flash('sms_warn', trans('require_field'));
                return Redirect::to('unit/new');
            }else{
                $unitnew=new RUnit();
                $unitnew->en=Input::get('unit');
                $unitnew->description=Input::get('description');

                if($unitnew->save()){
                    Session::flash('sms_success', trans('sta.save_data_success'));
                    return Redirect::to('unit');
                }
            }
        }
    }
    //=== Get ID to Delete from table Unit ===
    public function getDeleteform($id){
        $id = Crypt::decrypt($id);
        $unitdelete=RUnit::find($id);
        if($unitdelete->delete()){
            Session::flash('sms_success', trans('sta.save_data_success'));
            return Redirect::to('unit');
        }
    }
    
}


?>