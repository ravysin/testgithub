<?php

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
    // To use this function, requirment field name is ( id and label )
    public function array_list($data_obj){
        $array_list = array();
        $array_list[0]= "";
        $lang = Config::get('app.locale');
        if($lang=="en"){
            $array_list[0] = '-- All --';
        }else{
            $array_list[0] = '-- ទាំង​អស់ --';
        }
        
        foreach($data_obj as $data){
            $array_list[$data->id]=$data->label;
        }
        return $array_list;
    }
    // Validate is string is date. Return True or False
    public function is_date($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        //echo "<h1>this $date</h1>";
        return $d && $d->format('Y-m-d') == $date;
    }
    public function inversDate($date){
        $date_array = explode('-',$date);
        if(sizeof($date_array)==3){
            return $date_array[2] . '-' . $date_array[1] . '-' . $date_array[0];
        }else{
            return "";
        }
    }
    public function date_only($date)
    {
        $date_f = $this->inversDate($date);
        if($this->is_date($date_f)){
            return $date_f;
        }else{
            return Null;
        }
    }
    
}
