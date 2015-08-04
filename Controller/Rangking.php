<?php 

class Rangking extends BaseController{

	
	private $grandTotal = array();
	
	function walk_array_value($key){
		return $key['value'];
	}
	
	function array_mapping($var){
		$variable = array_map(function($x){ return $x['value']; }, $var);
		return $variable;
	}
	
	function graph($dataXY=null){		
		$data['layout'] = 'ajax';
		$params =  Core::Request();
		
		$this->view('rangking/graph',$data);
	}

	function index(){	
		$params =  Core::Request();
		//$data['layout'] = 'ajax';
			
		
		if(!isset($params['year']))$params['year'] = '2014';		
		if(!isset($params['month'])) $params['month'] = 'januari';
		
		
		$data['title'] = "Perangkingan Kantor Cabang berdasarkan point pada <strong>{$params[month]} -  {$params[year]}</strong>";
		$data['header'] = 'Perangkingan Kantor Cabang berdasarkan point';
		$data['month'] = $params['month'];
		$data['year'] = $params['year'];
		
		//echo '<pre>';print_r($params);
		$profileModel = $this->loadmodel('ProfileModel');
		$aspek =$this->loadmodel('CriteriaModel')->all();
		$offices = $this->loadmodel('OfficeModel')->all();
		$profiles = $profileModel->getByDate($params['month'],$params['year']);
		$option = $this->loadmodel('ProfileOptionModel');
		// echo '<pre>';
		// print_r($aspek);
		// exit;
		foreach($aspek as $_aspek){	
			$profile = new ProfileMatching();
			$profile->candidate = array_map(function($x){ return $x['office_id']; }, $profiles);
			$sub = $this->loadmodel('SubcriteriaModel');
			//echo $_aspek['id'];
			$sub_aspek = $sub->getSubbyParentId($_aspek['id']);		
			$profile->variable = array_map(function($x){ return $x['value']; }, $sub_aspek);
			$factor = array_map(function($x){ return $x['factor']; }, $sub_aspek);
			// $CF =  array_map(function($x){ return $x['value']; }, $sub->getCoreFactor());
			// $SF =  array_map(function($x){ return $x['value']; }, $sub->getSecondaryFactor());
			foreach($factor as $index => $sub_pek){
				if($sub_pek === 'NSF'){
					$profile->secondary_factor[] = ($index);
				} else {
					$profile->core_factor[] = ($index);
				}
				
			}
			
			foreach($profile->candidate as $office){
				$params['parent'] = $_aspek['id'];				
				$params['office'] = $office;
				//$values[] = $option-> getvalues ($params);
				$profile->values[$office] = $this->array_mapping($option-> getvalues ($params));
				
				//$values[$_aspek['id']][] = $option-> getvalues ($params);
			}
			
			// $profile->core_factor = array(0,1,3,4);
			// $profile->secondary_factor = array(2,5);
			$grandTotal[$_aspek['id']]['persentase'] = $_aspek['persentase'];
			$grandTotal[$_aspek['id']]['subtotal'] = $profile->calculate();
			
			//$profile->debug();
			// echo '<pre>';
			// print_r($profile);
			// echo '</pre>';
			// $officeModel = $this->loadmodel('OfficeModel');
			// foreach($rangking as $index=>$rang){
				// if(!empty($rang)){
					// $data['rangking'][$index]['detail'] = $officeModel->getProperty($index);
					// $data['rangking'][$index]['point'] = $rang;
				// }
				
			// }
			
			
		}
		// echo '<pre>';
		// print_r($grandTotal);
		// echo '</pre>';
		$nilai = array();
		foreach($grandTotal as $key => $newTotal){
			$persentase = $newTotal['persentase'];
			if(count($newTotal['subtotal']) > 1){
				foreach($newTotal['subtotal'] as $newKey => $subTotal){
					if(count($subTotal > 1))
					$nilai[$newKey] +=  $subTotal * ($persentase /100) ;
				}
			}
		
		}
		arsort($nilai);
		$data['rangking'] = ($nilai);
		$data['officeModel'] = $this->loadmodel('OfficeModel');
		$this->view('rangking/index',$data);
			
		// 2 ,3, 4,3
		// 1,3
		// pre($values);
		// $profile = new ProfileMatching();		
		// $profile->variable = array(2,3,1,4,3,3); // Tentukan varibale absolute u kandidat.
		// pre($profile->variable);
		// break;
		
		// $profile->candidate = array('T001','T002','T003','T004','T005');
		// $profile->values = array(
			// array(3,1,2,4,1,2),
			// array(4,4,3,1,1,3),
			// array(4,2,3,2,2,1),
			// array(2,1,3,3,2,1),
			// array(3,3,2,1,2,3)
		// );

		// $profile->core_factor = array(0,1,3,4);
		// $profile->secondary_factor = array(2,5);
		// $profile->calculate();
		// $profile->debug();
		// $subtotal = $profile->subTotal();
		// $profile->debug($subtotal);
		// $this->view('rangking/index',$data);
	}
	
	function Total(){
		$persen_core = (60/100);
		$persen_second = (40/100);
		$globals = '';
		if(is_array($this->ncf)){
			foreach($this->ncf as $key => $ncf){
				
				$globals[$key] = (($ncf * $persen_core ) + ($this->nsf[$key] * $persen_second ));
			}
		}
		if(!empty($globals))
		arsort($globals);
		$this->subtotal = $globals;
		
		return $this->subtotal;
	}

}