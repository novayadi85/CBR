<?php 
class ProfileModel extends BaseModel{
	
	protected $table = 'profiles';
	protected $pk	 = 'id';
	
	function getbyOffice($request){
		$db = new Db();
		$return = $db->query("SELECT {$this->table}.year,{$this->table}.month,
		{$this->table}.id AS profile_id , profiles_option.id AS option_id , profiles_option.sub_criteria_id, profiles_option.profile_persentase , 
		profiles_option.profile_value, offices.name , 
		sub_criteria.sub_criteria , criteria.id AS criteria_id ,sub_criteria.id as sub_criteria_id
		FROM {$this->table} inner join profiles_option 
		ON profiles.id = profiles_option.profile_id
		inner join offices ON profiles.office_id = offices.id 
		inner join sub_criteria ON profiles_option.sub_criteria_id = sub_criteria.id 
		inner join criteria ON criteria.id = sub_criteria.parent_id  
		WHERE profiles.office_id = {$request['office_id']} AND profiles.year = {$request['year']} AND profiles.month = '{$request['month']}'") ;
		return $return;
	}
	
	function getbyId($request){
		$db = new Db();
		$return = $db->query("SELECT {$this->table}.year,{$this->table}.month,
		{$this->table}.id AS profile_id ,profiles_option.id AS option_id, profiles_option.sub_criteria_id, profiles_option.profile_persentase , 
		profiles_option.profile_value, offices.name , 
		sub_criteria.sub_criteria , criteria.id AS criteria_id ,sub_criteria.id as sub_criteria_id
		FROM {$this->table} inner join profiles_option 
		ON profiles.id = profiles_option.profile_id
		inner join offices ON profiles.office_id = offices.id 
		inner join sub_criteria ON profiles_option.sub_criteria_id = sub_criteria.id 
		inner join criteria ON criteria.id = sub_criteria.parent_id WHERE
		 profiles.id = '{$request}'") ;
		return $return;
	}

	function getByDate($month,$year){
		$db = new Db();
		$return = $db->query("SELECT `id`, `month`, `year`, `office_id` FROM `{$this->table}` WHERE `month` = '{$month}' AND `year` = '{$year}'");
		return $return;
	}

}