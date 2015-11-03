<?php 
class User extends BaseController{

	public $data = array();
	function __construct(){
		
		parent::__construct();
		$this->data['layout'] = 'adminhtml';
		$this->data['header'] = 'Pengguna';
		
	}
	
	function index(){
		$users = $this->loadmodel('UserModel');
		$this->data['title'] = "Data Pengguna";
		$this->data['header'] = 'Pengguna';
		$this->data['users'] = $users->all();
		$this->view('user/index',$this->data);
	}
	
	function dashboard(){
		$users = $this->loadmodel('UserModel');
		$data['title'] = "Dashboard";
		$data['header'] = 'Dashboard';
		$data['users'] = $users->all();
		$data['layout'] = 'adminhtml';
		$data['title'] = "Backend";
		$ProblemModel = $this->loadmodel('SearchModel');
		$JurnalModel = $this->loadmodel('JurnalModel');
		$LecturerModel = $this->loadmodel('LecturerModel');
		$StudentModel = $this->loadmodel('StudentModel');
		$data['lecturer'] = $LecturerModel->count('*');
		$data['jurnal'] = $JurnalModel->count('*');
		$data['student'] = $StudentModel->count('*');
		$data['problem'] = $ProblemModel->query("SELECT count as value, term as label FROM `problems` GROUP BY `term` ORDER BY `id_problem` DESC");
		$data['problemb'] = $ProblemModel->query("SELECT count , term  FROM `problems` GROUP BY `term` ORDER BY `id_problem` DESC");
		$data['problem'] = json_encode($data['problem']);
		$data['problemb'] = json_encode($data['problemb']);
		$this->data = $data;
		$this->view('admin/index',$this->data);
	}

	
	function invalid(){
		$this->data['title'] = "Pengguna";
		$this->data['layout'] = 'login';		
		$users = $this->loadmodel('UserModel');
		$this->view('user/login',$this->data);
	}
	
	function login(){
		$request = Core::Request();
		$users = $this->loadmodel('UserModel');
		$username = $request['username'];
		$password = $request['password'];
		//$users->username = 'admin';
		$sql = "SELECT * FROM `users` WHERE `username` = '{$username}' AND `password` = ('{$password}')";

		$userLogin = $users->query($sql);
		// $userLogin = 1;
		
		if(!empty($userLogin)){
			$_SESSION['loggedIn'] = $userLogin;
			$this->dashboard();
			//header('Location: http://localhost/new-cbr');
		} else {
			$this->invalid();
		}
		
	}
	
	function logout(){
		unset($_SESSION['loggedIn']);
		$this->invalid();
	}
	
	function addnew($data=array()){
		$this->data['title'] = lang('Add new user');	
		$this->data['header'] = lang('Add new user');
		$this->view('user/addnew',$this->data);
	}
	
	function save(){
		$request = Core::Request();
		if(!empty($request)){
			//$this->__validusername($request['username']);
			if(!$this->__validusername($request['username'])){
				$this->data['msg'] = addError(lang('Your username has been taked.'));
				$this->data['request'] = $request;
				$this->addnew($this->data);
				return false;
				
			} else {
			
				$user = $this->loadmodel('UserModel');
				$user->username = $request['username'];
				$user->password = ($request['password']);
				$user->address = $request['address'];
				$user->name = $request['name'];
				if($user->Create()){
					$this->data['msg'] = addSuccess(lang('Your new user has been saved.'));
					$this->addnew($this->data);
				}
			
			}
		}
		//pre($request);exit;
	}
	
	function delete($post){
		//pre($post);exit;
		$user = $this->loadmodel('UserModel');
		$user->id = $post['params'];
		if($user->Delete()){
			$data['msg'] = addSuccess(lang('1 User has been deleted.'));
		} else {
			$data['msg'] = addError(lang('Unsuccess delete this user.'));
		}
		
		$this->data['title'] = lang('Management user');	
		$this->data['header'] = lang('Management user');
		$this->index();
		$user->Find();
		$data['user'] = $user->variables;
			
	}
	
	function edit(){
		$params =  Core::Request();
		$user = $this->loadmodel('UserModel');
		$user->id = $params['params'];
		$user->Find();
		$this->data['title'] = lang('Edit user');	
		$this->data['header'] = lang('Edit new user');
		$this->data['request'] = $user->variables;
		$this->view('user/edit',$this->data);
		
	}
	
	function update(){
		$request = Core::Request();
		//print_r($request);
		if(!empty($request)){
			//$this->__validusername($request['username']);			
			$user = $this->loadmodel('UserModel');
			$user->id = $request['params'];
			if(!empty($request['password'])){
				$user->password = ($request['password']);
			} 
			
			$user->address = $request['address'];
			$user->name = $request['name'];
			if($user->Save()){
				$this->data['msg'] = addSuccess(lang('This user has been updated.'));
				$this->index();
			} else {
				$this->data['msg'] = addError(lang('This user unsuccess update.'));
				$this->index();
			}

		}
		//pre($request);exit;
	}
	
	private function __validusername($username){
		// $user = $this->loadmodel('UserModel');
		// $user->username = $username;
		// $user->Find();
		
		// if($user->variables){
			// return false;
		// } 
		
		return true;
	}
}