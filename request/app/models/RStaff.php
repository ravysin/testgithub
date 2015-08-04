<?php
class RStaff extends Eloquent{

    //=== Select all Staff Request ===
	public static function getallrequeststaff()
	{	
		/*$sql  = "select
                    emp.id as id,
                    emp.en as emp_eng,
                    emp.kh as emp_kh,
                    gen.en as gen_en,
                    gen.kh as gen_kh,
                    pos.en as pos_en,
                    pos.kh as pos_kh,
                    dep.en as dep_en,
                    dep.kh as dep_kh,
                    org.en as org_en,
                    org.kh as org_kh,
                    emp.telephone as telephone
                from employees emp
                left join genders gen ON emp.gender_id=gen.id
                left join positions pos ON emp.position_id=pos.id
                left join departments dep ON emp.department_id=dep.id
                left join  organizations org ON emp.organization_id=org.id
                inner join r_staffs rs ON emp.id=rs.EmployeeID
                WHERE rs.is_delete=1";  */
         // return DB::select($sql);

        return DB::table('employees as emp')
                 ->leftJoin('genders as gen','emp.gender_id','=','gen.id')
                 ->leftJoin('positions as pos','emp.position_id','=','pos.id')
                 ->leftJoin('departments as dep','emp.department_id','=','dep.id')
                 ->leftJoin('organizations as org','emp.organization_id','=','org.id')
                 ->join('r_staffs as rs','emp.id','=','rs.EmployeeID')
                 ->where('rs.is_delete','=',1)
                 ->select('emp.id as id',
                          'emp.en as emp_eng',
                          'emp.kh as emp_kh',
                          'gen.en as gen_en',
                          'gen.kh as gen_kh',
                          'pos.en as pos_en',
                          'pos.kh as pos_kh',
                          'dep.en as dep_en',
                          'dep.kh as dep_kh',
                          'org.en as org_en',
                          'org.kh as org_kh',
                          'emp.telephone as telephone'
                )->get();
	}
    //=== End Select all Staff Request ===
}
?>