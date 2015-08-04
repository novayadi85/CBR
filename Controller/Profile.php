<?php 
class Profile extends BaseController{

	public $data = array();

	function index(){
		$profiles = $this->loadmodel('ProfileModel');
		$this->data['office'] = $this->loadmodel('OfficeModel');
		$this->data['title'] = "PENILAIAN KANTOR CABANG";
		$this->data['header'] = 'PENILAIAN KANTOR CABANG';
		$this->data['profiles'] = $profiles->all();
		$this->view('profile/index',$this->data);
	}
	
	function addnew($data=array()){
		$data['title'] = lang('PENILAIAN KANTOR CABANG');	
		$data['header'] = lang('PENILAIAN KANTOR CABANG');
		$offices = $this->loadmodel('OfficeModel');
		$criterias = $this->loadmodel('CriteriaModel');
		$profiles = $this->loadmodel('ProfileModel');
		$data['offices'] = $offices->all();
		$data['criterias'] = $criterias->all();
		$this->view('profile/addnew',$data);
	}
	
	function save(){
		$request = Core::Request();
		
		if(!empty($request) && $request['action'] =='new' ){
			$profile = $this->loadmodel('ProfileModel');
			$profile->month = $request['month'];
			$profile->year = $request['year'];
			$profile->office_id = $request['office_id'];
			if($profile->Create()){
				
				foreach($request['sub'] as $key => $subs){
					$profile_option = $this->loadmodel('ProfileOptionModel');
					$profile_option->profile_id = $profile->lastInsertId();
					$profile_option->sub_criteria_id = $key;
					$profile_option->profile_persentase = $subs;
					$profile_option->profile_value = $this->grade($subs);
					$profile_option->Create();
				}

				$this->data['msg'] = addSuccess(lang('Penilaian berhasil disimpan.'));
				$this->index();
			}
		} else {
			$this->update();
		}
		
		
		
	}
	
	function delete($post){
		//pre($post);exit;
		$Profile = $this->loadmodel('ProfileModel');
		$Profile->id = $post['params'];
		if($Profile->Delete()){
			$data['msg'] = addSuccess(lang('1 Profile has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this Profile.'));
		}
		
		$data['title'] = lang('Management Profile');	
		$data['header'] = lang('Management Profile');
		$this->data = $data;
		$this->index();
		$Profile->All();
		$data['profile'] = $Profile->variables;
			
	}
	
	function edit(){
		$params =  Core::Request();
		$Profile = $this->loadmodel('ProfileModel');
		$Profile->id = $params['params'];
		$Profile->Find();
		$data['title'] = lang('Edit Profile');	
		$data['header'] = lang('Edit new Profile');
		$data['request'] = $Profile->variables;
		$this->view('profile/edit',$data);
		
	}
	
	function detail($id){
		$data['title'] = lang('Ubah Nilai Kantor Cabang');	
		$data['header'] = lang('Ubah Nilai Kantor Cabang');
		$request = Core::Request();
		$Profile = $this->loadmodel('ProfileModel');
		$this->loadmodel('ProfileOptionModel');		
		$oldProfile = $Profile->getbyId($request['params']);		
		$getCriteria = $this->loadmodel('CriteriaModel');
		$data['criteria']  = array2Object($getCriteria->all());
		$this->loadmodel('SubcriteriaModel');
		//pre($oldProfile);
		 // getSubbyParentId
		if($oldProfile){
			$data['error'] = true;
			$data['action'] = 'update';
			$data['profile'] = $oldProfile;
			$data['profile_id'] = $request['params'];
			//Data sudah ada tampilkan data lama.
			$this->view('profile/detail',$data);

			
		}
	}
	
	function update(){
		$request = Core::Request();
		// pre($request);exit;
		if(!empty($request) && $request['action'] =='update' ){		
				$succes = 0;
				foreach($request['sub'] as $key => $subs){
					$profile_option = $this->loadmodel('ProfileOptionModel');
					//$profile_option->setPK('sub_criteria_id') ;
					$profile_option->id = $key;
					$profile_option->profile_id = $request['profile_id'];
					
					foreach($subs as $subkey => $value){
						$profile_option->sub_criteria_id = $subkey;
						$profile_option->profile_persentase = $value;
						$profile_option->profile_value = $this->grade($value);
					}
					
					//pre($profile_option);
					if($profile_option->Save()){
						$succes = true;
					}
				}
			
				$this->data['msg'] = addSuccess(lang('Penilaian berhasil diubah.'));
				$this->index();


		}
		//pre($request);exit;
	}
	
	private function __validusername($username){
		$office = $this->loadmodel('ProfileModel');
		$office->username = $username;
		$office->Find();
		
		if($office->variables){
			return false;
		} 
		
		return true;
	}
	
	
	public function loadprofile(){
		$data['layout'] = 'ajax';	
		$request = Core::Request();
		$Profile = $this->loadmodel('ProfileModel');
		$this->loadmodel('ProfileOptionModel');		
		$oldProfile = $Profile->getbyOffice($request);		
		$getCriteria = $this->loadmodel('CriteriaModel');
		$data['criteria']  = array2Object($getCriteria->all());
		$this->loadmodel('SubcriteriaModel');
		 // getSubbyParentId
		if($oldProfile){
			$data['error'] = true;
			$data['action'] = 'update';
			$data['profile'] = $oldProfile;
			//Data sudah ada tampilkan data lama.
			$this->view('profile/selection_update',$data);

			
		} else {
		
			//Data tidak ada silakan masukkan data baru.
			$data['error'] = false;
			$data['action'] = 'new';
			$data['profile'] = $oldProfile;
			$this->view('profile/selection',$data);
			
		}
				
		

	
	}

	private function grade($value){
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