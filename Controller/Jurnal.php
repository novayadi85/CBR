<?php 
class Jurnal extends BaseController{

	public $data = array();
	
	function __construct(){
		parent::__construct();
		$this->data['layout'] = 'adminhtml';
	}
	
	function add($request = false){
		if($request)
			$this->data['request'] = $request ;
		$lecturer = $this->loadmodel('LecturerModel');
		$this->data['lecturer'] =  $lecturer->all();
		$this->data['title'] = "Add Jurnal";
		$this->view('jurnal/admin/add',$this->data);
	}
	
	function edit(){
		$params =  Core::Request();
		
		if($params['params']){
			$jurnal = $this->loadmodel('JurnalModel');
			$jurnal->id_jurnal = $params['params'];
			$jurnal->Find();
			$this->data['request'] = $jurnal->variables;
		}
		$lecturer = $this->loadmodel('LecturerModel');
		$this->data['lecturer'] =  $lecturer->all();
		//print_r($this->data)	;
		$this->data['title'] = "Add Jurnal";
		$this->view('jurnal/admin/edit',$this->data);
	}

	function index(){
		$this->data['title'] = "Jurnal";
		$jurnal = $this->loadmodel('JurnalModel');
		$this->data['Model'] =  $this->loadmodel('LecturerModel');
		$this->data['jurnals'] = $jurnal->all();
		$this->view('jurnal/admin/index',$this->data);
	}
	
	function save(){
		$request = Core::Request();
		$params =  Core::Request();
		//$this->pre($request); exit();
		if(!empty($params['params'])){
			$updater = $this->loadmodel('JurnalModel');
			$updater->id_jurnal = $params['params'];
			$updater->Find();
			
		}
		
		if(!empty($request)){
			$jurnal = $this->loadmodel('JurnalModel');
			$jurnal->nim = $request['nim'];
			$jurnal->title = $request['title'];
			$jurnal->text = $request['abstract'];
			$jurnal->year = $request['year']; 
			$jurnal->created = date('Y-m-d');
			$jurnal->user_id = 1; 
			$jurnal->lecturer_ids = implode(",",$request['lecturer_ids']);
			//$jurnal->filepath = '/test/';
			
			if ($_FILES['file']['size'] > 0) {
				$uploader = $this->library('Libs_Upload');	
				$uploader->setDir(FILE_PATH);
				$uploader->setExtensions(array('docx','doc'));  //allowed extensions list//
				$uploader->setMaxSize(10);                          //set max file size to be allowed in MB//
				$uploader->sameName(false);
				if($uploader->uploadFile('file')){   //txtFile is the filebrowse element name //     
					$image  =   $uploader->getUploadName(); //get uploaded file name, renames on upload//
					$jurnal->filepath = $image; 
					$docObj = $this->library('DocxConversion');
					$docObj->setFile(FILE_PATH . $image);
					$oFile = $docObj->convertToText();
					$sId = explode(".",$image);
					$vals = array();
					$vals['penulis'] = $request['nim'];
					$vals['title'] = $request['title'];
					$vals['th_buat'] = $request['year'];
					$vals['ID'] = $request['nim'];
					if($xml = $this->library('xml')->createXML($oFile,$sId[0],$vals)){
						$jurnal->filetext = $xml;
					}
				}else{//upload failed
					$this->data['msg'] = addError($uploader->getMessage()); //get upload error message 
					$this->add($request);
				}
			}
			
			if(!empty($params['params']) ){
				
				$jurnal->id_jurnal = $params['params'];
				//echo FILE_DIR.DS.'xml'.DS.$updater->variables['filetext'];
				if(!empty($xml)){
					$unlink = unlink(FILE_DIR.'xml'.DS.$updater->variables['filetext']);				
				}

				if(!empty($image) && file_exists(FILE_PATH.$updater->variables['filepath'])){
					$unlink = unlink(FILE_PATH.$updater->variables['filepath']);						
				}
				
				if($jurnal->Save()){
					$this->data['msg'] = addSuccess(lang('Your new jurnal has been saved.'));
					$this->index();
				} else {
					
					$this->data['msg'] = addError(lang('Your dont have any changed.'));
					$this->index();
				}
			} else {
				if($jurnal->Create()){
					$this->data['msg'] = addSuccess(lang('Your new jurnal has been saved.'));
					$this->index();
				}
			}

			
		}
		//pre($request);exit;
	}

	function delete($post){
		$jurnal = $this->loadmodel('JurnalModel');
		$jurnal->id_jurnal = $post['params'];
		$jurnal->Find();
		$filepath = $jurnal->variables['filepath'];
		$filetext = $jurnal->variables['filetext'];
		
		if($jurnal->Delete()){
			if(!empty($filepath) && file_exists(FILE_PATH.$filepath)){
				$unlink = unlink(FILE_PATH.$filepath);						
			}
			if(!empty($filetext) && file_exists(FILE_DIR.'xml'.DS.$filetext)){
				$unlink = unlink(FILE_DIR.'xml'.DS.$filetext);				
			}
			
			$data['msg'] = addSuccess(lang('1 jurnal has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this jurnal.'));
		}		
		$data['title'] = lang('Management jurnal');	
		$data['header'] = lang('Management jurnal');
		$data['layout'] = 'adminhtml';
		$this->data = $data;
		$this->index();
		$jurnal->All();
		$data['jurnal'] = $jurnal->variables;
			
	}
}