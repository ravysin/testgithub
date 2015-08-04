<?php

class ItemtypeController extends BaseController{
    //=== Index Page Item Type ===
    public function getIndex(){
        $itemtypegets=RItemType::get_allItemtype();
        return View::make('item_type.listitemtype',array('itemtypegets'=>$itemtypegets,));     
    }
    //=== Get New Form to New Item Type ===
    public function getNew(){
        return View::make('item_type.new');
    } 
    //=== Post New Form to Save New Item Type ===
    public function postNew(){
        if(Input::has('save')){
            if(strlen(Input::get('itemtype'))<2){
                Session::flash('sms_warn', trans('require_field'));
                return Redirect::to('itemtype/new');
            }else{
                $itemtypenew=new RItemType();
                $itemtypenew->en=Input::get('itemtype');
                $itemtypenew->description=Input::get('description');

                if($itemtypenew->save()){
                    Session::flash('sms_success', trans('sta.save_data_success'));
                    return Redirect::to('itemtype');
                }
            }
        }
    }
    //=== Get ID to Delete from table Itemtype ===
    public function getDeleteform($id){
        $id = Crypt::decrypt($id);
        $itemtypelete=RItemType::find($id);
        if($itemtypelete->delete()){
            Session::flash('sms_success', trans('sta.save_data_success'));
            return Redirect::to('itemtype');
        }
    }

}


?>