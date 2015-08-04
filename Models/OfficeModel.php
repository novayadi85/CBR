<?php 
class OfficeModel extends BaseModel{
	
	protected $table = 'offices';
	protected $pk	 = 'id';
	
	
	function getName($office_id){
		$db = new Db();
		$return = $db->query("SELECT * FROM offices WHERE `id` = {$office_id}");
		return $return[0]['name'];
	}
	
	function getProperty($office_id){
		$db = new Db();
		$return = $db->query("SELECT * FROM offices WHERE `id` = {$office_id}");
		return $return[0];
	}

}