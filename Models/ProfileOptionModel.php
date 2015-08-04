<?php 
class ProfileOptionModel extends BaseModel{
	
	protected $table = 'profiles_option';

	public $pk	 = 'id';
	
	public function setPK($variable){
		$this->pk = $variable;
	}
	
	function getByProfile($id){
		$db = new Db();
		$return = $db->query("SELECT * FROM `profiles_option` WHERE `profile_id` = {$id}");
		return $return;
	}
	
	
	function getvalues($params){
		$db = new Db();
		$return = $db->query("SELECT profiles_option.profile_value AS value from profiles_option 
		INNER JOIN sub_criteria 
		ON profiles_option.sub_criteria_id = sub_criteria.id INNER JOIN 
		criteria ON sub_criteria.parent_id = criteria.id INNER JOIN profiles 
		ON profiles_option.profile_id = profiles.id 
		WHERE criteria.id = '{$params['parent']}' 
		AND profiles.office_id = '{$params['office']}' 
		AND profiles.year = '{$params['year']}'  
		AND profiles.month = '{$params['month']}'");
	/* 	echo "SELECT profiles_option.profile_value AS value from profiles_option 
		INNER JOIN sub_criteria 
		ON profiles_option.sub_criteria_id = sub_criteria.id INNER JOIN 
		criteria ON sub_criteria.parent_id = criteria.id INNER JOIN profiles 
		ON profiles_option.profile_id = profiles.id 
		WHERE criteria.id = '{$params['parent']}' 
		AND profiles.office_id = '{$params['office']}' 
		AND profiles.year = '{$params['year']}'  
		AND profiles.month = '{$params['month']}'"; */
		return $return;
	}
}