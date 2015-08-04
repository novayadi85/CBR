<?php 
class Subcriteria extends BaseController{

	public $data = array();

	function index(){
		$subcriterias = $this->loadmodel('SubcriteriaModel');
		$this->data['title'] = "Sub Aspek";
		$this->data['header'] = 'Sub Aspek';
		$this->data['subcriterias'] = $subcriterias->all();
		$this->data['scriteria'] = $subcriterias->getCriteriabyId(1);
		$this->view('subcriteria/index',$this->data);
	}
	
	function addnew($data=array()){
		$data['title'] = lang('Tambah Sub Aspek');	
		$data['header'] = lang('Tambah Sub Aspek');
		$criteria = $this->loadmodel('CriteriaModel');
		$data['parents'] = $criteria->All();
		$this->view('subcriteria/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		//echo '<pre>'; print_r($request);exit;
		if(!empty($request)){
			$subcriteria = $this->loadmodel('SubcriteriaModel');
			$subcriteria->sub_criteria = $request['sub_criteria'];
			$subcriteria->parent_id = $request['parent_id'];
			$subcriteria->kode = $request['kode'];
			$subcriteria->persentase = $request['persentase'];
			$subcriteria->value = $this->grade($request['persentase']);
			$subcriteria->factor = $request['factor'];
			if($subcriteria->Create()){
				$this->data['msg'] = addSuccess(lang('Your new aspek has been saved.'));
				$this->index();
			}
		}
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$subcriteria = $this->loadmodel('SubcriteriaModel');
		$subcriteria->id = $post['params'];
		if($subcriteria->Delete()){
			$data['msg'] = addSuccess(lang('1 Aspek has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this aspek.'));
		}
		
		$data['title'] = lang('Sub Aspek');	
		$data['header'] = lang('Sub Aspek');
		$this->data = $data;
		$this->index();
		$subcriteria->All();
		$data['subcriteria'] = $subcriteria->variables;
			
	}
	
	function edit(){
		$params =  Core::Request();
		$criteria = $this->loadmodel('CriteriaModel');
		$subcriteria = $this->loadmodel('SubcriteriaModel');
		$subcriteria->id = $params['params'];
		$subcriteria->Find();
		$data['title'] = lang('Edit Sub Aspek');	
		$data['header'] = lang('Edit Sub Aspek');
		$data['request'] = $subcriteria->variables;		
		$data['parents'] = $criteria->All();
		$this->view('subcriteria/edit',$data);
		
	}
	
	function update(){
		$request = Core::Request();
		//echo '<pre>'; print_r($request);exit;
		if(!empty($request)){
			//$this->__validusername($request['username']);			
			$subcriteria = $this->loadmodel('SubcriteriaModel');
			$subcriteria->id = $request['params'];
			$subcriteria->sub_criteria = $request['sub_criteria'];
			$subcriteria->parent_id = $request['parent_id'];
			$subcriteria->kode = $request['kode'];
			$subcriteria->persentase = $request['persentase'];
			$subcriteria->value = $this->grade($request['persentase']);
			$subcriteria->factor = $request['factor'];
			//echo '<pre>'; print_r($subcriteria);exit;
			if($subcriteria->Save()){
				$this->data['msg'] = addSuccess(lang('This sub aspek has been updated.'));
				$this->index();
			} else{
				$this->data['msg'] = addError(lang('This sub aspek unsuccess update.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
	private function __validusername($username){
		$office = $this->loadmodel('OfficeModel');
		$office->username = $username;
		$office->Find();
		
		if($office->variables){
			return false;
		} 
		
		return true;
	}
	
	function grade($value){
		if($value <=20){
			return 1;
		} else if($value > 20 && $value <=40){
			return 2;
		
		} else if($value > 40 && $value <= 60){
			return 3;
		} else if($value > 60 && $value <= 80){
			return 4;
		} else if( $value > 80 ){
			return 5;
		}
	
	} 
	
	
}