<?php
class Hook extends Application {

	public $Hooks=array();

	public function __construct (){
		//$this->set_connection();
		//$this->setHook();
		$this->loadClassHook();
	}
	
	public function setHook($Hook=null){
		if(is_array($Hook)){
		$this->Hook = $Hook;
               //$this->pr($Hook);
		foreach($Hook as $ext){
			$id = ($ext['id_extra']);
                        $sql = self::getHookPosition($id,$ext['id_hook']);
                        $result = $this->FetchObject($sql);
                        $posisi = $result->title_hook;
                        
                        $file = $result->title_extra;
                        //$this->pr($result);
			$s = $this->NumRows($sql);
                       // $position = $this->FetchObject($sql);
                        
                        if($s>0){
					
					$bootstrap = APP . '/' .  WEB_CORE.'/libs/autoplug.php';
					if (file_exists($bootstrap)) {
						require  $bootstrap;
					}
					
					if(file_exists(APP .'/plugins/'.$file .'/'.$file.'.php')){
                    if(!class_exists($file))
						require (APP .'/plugins/'.$file .'/'.$file.'.php');	
					}
					
					$class = new $file;
                                       //echo $posisi;
                    (int)method_exists($class, '__display')? $class->__display($posisi):false;
	
				} 
                                
				
			}
		
		}
	}
	
	public function getHookHook($id=null){
		$query = mysql_query("SELECT * FROM extra, hook_extra WHERE extra.id_extra = hook_extra.id_extra AND hook_extra.id_hook='$id'");
		while($data = mysql_fetch_array($query)){
			$result[] = $data;
		}
                //$this->pr($result);
		return self::setHook($result);
	}
	
	public function is_setHook($id=null){

		$query = mysql_query("SELECT hook. * , hook_extra. * , extra. *
                                      FROM hook
                                      INNER JOIN hook_extra ON hook_extra.id_hook = hook.id_hook
                                      INNER JOIN extra ON hook_extra.id_extra = extra.id_extra
                                      WHERE extra.id_extra = '$id'
                                      AND extra.enable = '1'");
		while($data = mysql_fetch_object($query)){
			$result[] = $data;
		}
		return $result;
	}
        
        public function getHookPosition($id=null,$posisi=null){
		$query = $this->Query("SELECT hook. * , hook_extra. * , extra. *
                                      FROM hook
                                      INNER JOIN hook_extra ON hook_extra.id_hook = hook.id_hook
                                      INNER JOIN extra ON hook_extra.id_extra = extra.id_extra
                                      WHERE extra.id_extra = '$id' AND hook.id_hook = '$posisi'
                                      AND extra.enable = '1'");
		return $query;
	}
	
	
	public function _getExtra($result){
		
		foreach($result as $arr){
			$sql = mysql_query("SELECT title_hook FROM hook where id_hook = ".$arr['id_hook']." ");
			$data = mysql_fetch_array($sql);
			if($data['title_hook'] ==$this->side){
				 $return = $arr;
				
			}
		}
		$this->is_instal($return);
	}
	
	public function is_instal($mod){
		if(!empty($mod)){
			foreach($mod as $value => $left):
				$enable = $this->getExtra($left['title_extra']);
				if($enable){
					$array[] = $left['title_extra'];
				}
			endforeach;
			return $array;
		}
	}
	
	
	public function loadClassHook(){
		
		//extract($this->Hooks, EXTR_PREFIX_SAME, "wddx");
		
		foreach($this->Hooks as $ext){
			$file = ($ext['title_extra']);
			if(file_exists(APP .'/plugins/'.$file .'/'.$file.'.php')){
				require (APP .'/plugins/'.$file .'/'.$file.'.php');
			}
        }
	}
	
	public function getHook($side){
		self::set_connection();
		$id = self::_loadHook($side);
		self::getHookHook($id);
                }
	
	
	public function _loadHook($var){
		$var = trim($var);
		$sql = mysql_query("SELECT * FROM hook where title_hook ='$var'");
		$data = mysql_fetch_array($sql);
                //echo $data['id_hook'];
		return $data['id_hook'];
	}
	
	function getHookCSS($file){
		if(file_exists(APP .'/plugins/'.$file .'/css/'.$file.'.css')){
			include (APP .'/plugins/'.$file .'/css/'.$file.'.css');
		}
	
	}
	function HookPath($Hook=null){
		if($Hook!=null){
			$return = BASE_URL .'' . APP .'/plugins/'.$Hook;
			return $return; 
		}

	}

}
?>