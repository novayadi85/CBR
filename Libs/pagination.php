<?php

class pagination
    {
    var $page = 1; 
    var $perPage = 10; 
    var $showFirstAndLast = false;
     
    function generate($array, $perPage = 10,$hal=null)
    {
		//asort($array);
		
		if (!empty($perPage))
		$this->perPage = $perPage;
		
		if (!empty($hal)) {
			$this->page = $hal; 
		} else {
			$this->page = 1; 
		}
		 
		$this->length = count($array);
		$this->pages = ceil($this->length / $this->perPage);
		$this->start = ceil(($this->page - 1) * $this->perPage);
		
		$return = array_slice($array, $this->start, $this->perPage);

		return $return;
    }
     
    function links($hal,$url)
    {
		
		$plinks = array();
		$links = array();
		$slinks = array();
		
		unset($_GET['page']);
		unset($_GET['submit']);

		$this->page = (int)$hal;
		($this->page==0)?$this->page=$this->page+1:$this->page=$this->page;

		if (count($_GET)) {
			$queryURL = '';
			foreach ($_GET as $key => $value) {

				if ($key != 'q') {
					$queryURL .= '&';
				} else {
					$queryURL .= '?';
				}
				if($key!='ajax'){
					$queryURL .= $key.'='.$value;
				}
				
			}
		}
		//$queryURL = $_GET;	
		if (($this->pages) > 1)
		{

			if ($this->page != 1) {
				if ($this->showFirstAndLast) {
					$plinks[] = ' <a href="'.$url.'/1/'.$queryURL.'">&laquo;&laquo; First </a> ';
				}
				$plinks[] = ' <span class="prevnext"><a href="'.$url.'/'.($this->page - 1).'/'.$queryURL.'">&laquo; Prev</a> </span>';
			}
     
			for ($j = 1; $j < ($this->pages + 1); $j++) {
				if ($this->page == $j) {
					$links[] = ' <span class="current">'.$j.'</span> ';
				} else {
					$links[] = ' <a href="'.$url.'/'.$j.'/'.$queryURL.'">'.$j.'</a> ';  
				}
			}
     
    
			if ($this->page < $this->pages) {
				$slinks[] = ' <span class="prevnext"><a href="'.$url.'/'.($this->page + 1).'/'.$queryURL.'"> Next &raquo; </a> ';
					if ($this->showFirstAndLast) {
						$slinks[] = ' <a href="'.$url.'/'.($this->pages).'/'.$queryURL.'"> Last &raquo;&raquo; </a> </span>';
					}
			}
     
   
			return implode(' ', $plinks).implode($this->implodeBy, $links).implode(' ', $slinks);
		}
    return;
    }
}
?>