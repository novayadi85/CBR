<?php 
class SubcriteriaModel extends BaseModel{
	
	protected $table = 'sub_criteria';
	protected $pk	 = 'id';
	
	function getCriteria(){
		
		$db = new Db();
		
		//$db->query("SELECT * FROM Persons WHERE firstname = :firstname AND id = :id");
		return $return = $db->query("SELECT sub_criteria.id, criteria.id AS parent_id, criteria.criteria AS criteria
			FROM `criteria`
			INNER JOIN `sub_criteria` 
			ON criteria.id = sub_criteria.parent_id");
	}

	function getCriteriabyId($id){
		
		$db = new Db();
		
		//$db->query("SELECT * FROM Persons WHERE firstname = :firstname AND id = :id");
		$return = $db->query("SELECT sub_criteria.id, criteria.id AS parent_id, criteria.criteria AS criteria
			FROM `criteria`
			INNER JOIN `sub_criteria` 
			ON criteria.id = sub_criteria.parent_id 
			WHERE sub_criteria.parent_id = {$id} LIMIT 1");

		return $return[0]['criteria'];
	}
	
	function getSubbyParentId($id){
		$db = new Db();
		$return = $db->query("SELECT * FROM `sub_criteria` WHERE `parent_id` = {$id}");
		return $return;
	}
	
	function getCoreFactor(){
		$db = new Db();
		$return = $db->query("SELECT value FROM `sub_criteria` WHERE `factor` = 'NCF'");
		return $return;
	}
	
	function getSecondaryFactor(){
		$db = new Db();
		$return = $db->query("SELECT value FROM `sub_criteria` WHERE `factor` = 'NSF'");
		return $return;
	}
	
	function getValueByParent($id){
		$db = new Db();
		$return = $db->query("SELECT `value` FROM `sub_criteria` WHERE `parent_id` = {$id}");
		return $return;
	}
	
}