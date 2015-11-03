<?php 
class Student extends BaseController{

	public $data = array();
	
	function __construct(){
		parent::__construct();
		$this->data['layout'] = 'adminhtml';
		$this->data['header'] = 'Data Mahasiswa';
		
	}
	
	function add($request=null){
		$this->data['title'] = "Tambah Data Mahasiswa";
		if(!is_null($request))
			$this->data['request'] = $request;
		$this->view('student/admin/add',$this->data);
	}
	
	function edit(){
		$params =  Core::Request();
		if($params['params']){
			$StudentModel = $this->loadmodel('StudentModel');
			$StudentModel->nim = $params['params'];
			$StudentModel->Find();
			$this->data['request'] = $StudentModel->variables;
		}
		$this->data['title'] = "Ubah Data Mahasiswa";
		$this->view('student/admin/edit',$this->data);
	}

	function index(){
		$this->data['title'] = "Data Mahasiswa";
		$students = $this->loadmodel('StudentModel');
		$this->data['students'] = $students->all();
		$this->view('student/admin/index',$this->data);
	}
	
	function save(){
		$request = Core::Request();
		$params =  Core::Request();
		
		if(!empty($params['params'])){
			$updater = $this->loadmodel('StudentModel');
			$updater->nim = $params['params'];
			$updater->Find();		
		} else {

			$check = $this->loadmodel('StudentModel');
			$check->nim = $request['nim'];
			$check->Find();
			// $this->pre($check);
			//$Lecturer->photo = 'no-photo.png';
			if(!empty($check->variables)){
				$this->data['msg'] = addError('Data dengan NIM tersebut sudah ada..'); //get upload error message 
				$this->add($request);
				exit();				
			}
		}
		
		if(!empty($request)){
			$student = $this->loadmodel('StudentModel');
			$student->nim = $request['nim'];
			$student->name = $request['name'];
			$student->address = $request['address'];
			//$student->photo = $request['photo'];
			if ($_FILES['photo']['size'] > 0) {
				$uploader = $this->library('Libs_Upload');	
				$uploader->setDir(FILE_PATH . 'photo'.DS.'student' . DS);
				$uploader->setExtensions(array('jpg','png'));  //allowed extensions list//
				$uploader->setMaxSize(10);                          //set max file size to be allowed in MB//
				$uploader->sameName(false);
				if($uploader->uploadFile('photo')){   //txtFile is the filebrowse element name //     
					$image  =   $uploader->getUploadName();
					$student->photo = $image;
				}else{//upload failed
					$this->data['msg'] = addError($uploader->getMessage()); //get upload error message 
					$this->add($request);
					exit();
				}
			} 
			
			if(!empty($params['params']) ){				
				$student->nim = $params['params'];
				if(!empty($image) && file_exists(FILE_PATH.'photo'.DS.'student'.DS.$updater->variables['photo'])){
					$unlink = unlink(FILE_PATH.'photo'.DS.'student'.DS.$updater->variables['photo']);						
				}
				
				if($student->Save()){
					$this->data['msg'] = addSuccess(lang('Your new student has been saved.'));
					$this->index();
				} else {
					
					$this->data['msg'] = addError(lang('Your dont have any changed.'));
					$this->index();
				}
			} else {
				if($student->Create()){
					$this->data['msg'] = addSuccess(lang('Your new student has been saved.'));
					$this->index();
				}
			}
		}
		//pre($request);exit;
	}
	function delete(){
		$post =  Core::Request();
		$Student = $this->loadmodel('StudentModel');
		$Student->nim = $post['params'];
		if($Student->Delete()){
			$data['msg'] = addSuccess(lang('1 Student has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this Student.'));
		}		
		$data['title'] = lang('Management student');	
		$data['header'] = lang('Management student');
		$data['layout'] = 'adminhtml';
		$this->data = $data;
		$this->index();
		$Student->All();
		$data['students'] = $Student->variables;
			
	}
}