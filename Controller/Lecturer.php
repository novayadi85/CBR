<?php 
class Lecturer extends BaseController{

	public $data = array();
	
	function __construct(){
		parent::__construct();
		$this->data['layout'] = 'adminhtml';
		$this->data['header'] = 'Data Dosen';
	}
	
	function add($request=null){
		$this->data['title'] = "Tambah Data Dosen";
		if(!is_null($request))
			$this->data['request'] = $request;
		$this->view('lecturer/admin/add',$this->data);
	}
	
	function edit(){
		$params =  Core::Request();
		
		if($params['params']){
			$LecturerModel = $this->loadmodel('LecturerModel');
			$LecturerModel->id_lecturer = $params['params'];
			$LecturerModel->Find();
			$this->data['request'] = $LecturerModel->variables;
		}
		$this->data['title'] = "Tambah Data Dosen";
		$this->view('lecturer/admin/edit',$this->data);
	}

	function index(){
		$this->data['title'] = "Data Dosen";
		$criterias = $this->loadmodel('LecturerModel');
		$this->data['lecturers'] = $criterias->all();
		$this->view('lecturer/admin/index',$this->data);
	}
	
	function save(){
		$request = Core::Request();
		$params =  Core::Request();
		
		if(!empty($params['params'])){
			$updater = $this->loadmodel('LecturerModel');
			$updater->id_lecturer = $params['params'];
			$updater->Find();		
		} else {
			$Lecturer->photo = 'no-photo.png';
		}
		
		
		if(!empty($request)){
			$Lecturer = $this->loadmodel('LecturerModel');
			$Lecturer->nip = $request['nip'];
			$Lecturer->name = $request['name'];
			$Lecturer->address = $request['address'];
			
			if ($_FILES['photo']['size'] > 0) {
				$uploader = $this->library('Libs_Upload');	
				$uploader->setDir(FILE_PATH . 'photo' . DS);
				$uploader->setExtensions(array('jpg','png'));  //allowed extensions list//
				$uploader->setMaxSize(10);                          //set max file size to be allowed in MB//
				$uploader->sameName(false);
				if($uploader->uploadFile('photo')){   //txtFile is the filebrowse element name //     
					$image  =   $uploader->getUploadName();
					$Lecturer->photo = $image;
				}else{//upload failed
					$this->data['msg'] = addError($uploader->getMessage()); //get upload error message 
					$this->add($request);
					exit();
				}
			}  
			
			
			if(!empty($params['params']) ){
				
				$Lecturer->id_lecturer = $params['params'];

				if(!empty($image) && file_exists(FILE_PATH.'photo'.DS.$updater->variables['photo'])){
					$unlink = unlink(FILE_PATH.'photo'.DS.$updater->variables['photo']);						
				}
				
				if($Lecturer->Save()){
					$this->data['msg'] = addSuccess(lang('Your new Lecturer has been saved.'));
					$this->index();
				} else {
					
					$this->data['msg'] = addError(lang('Your dont have any changed.'));
					$this->index();
				}
			} else {
				if($Lecturer->Create()){
					$this->data['msg'] = addSuccess(lang('Your new criteria has been saved.'));
					$this->index();
				}
			}
		}
		//pre($request);exit;
	}
	
	function delete($post){
		$lecturer = $this->loadmodel('LecturerModel');
		$lecturer->id_lecturer = $post['params'];
		if($lecturer->Delete()){
			$data['msg'] = addSuccess(lang('1 lecturer has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this lecturer.'));
		}		
		$data['title'] = lang('Management lecturer');	
		$data['header'] = lang('Management lecturer');
		$data['layout'] = 'adminhtml';
		$this->data = $data;
		$this->index();
		$lecturer->All();
		$data['lecturer'] = $lecturer->variables;
			
	}
}