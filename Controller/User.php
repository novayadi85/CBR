<?php 
class User extends BaseController{

	public $data = array();
	function __construct(){
		
		parent::__construct();
		$this->data['layout'] = 'adminhtml';
	}
	
	function index(){
		$users = $this->loadmodel('UserModel');
		$this->data['title'] = "Management users";
		$this->data['header'] = 'USERS';
		$this->data['users'] = $users->all();
		$this->view('user/index',$this->data);
	}
	
	function invalid(){
		$this->data['title'] = "User Login";
		$this->data['layout'] = 'login';		
		$users = $this->loadmodel('UserModel');
		$this->view('user/login',$this->data);
	}
	
	function login(){
		$request = Core::Request();
		
		$users = $this->loadmodel('UserModel');
		$users->username = 'admin';		
		$users->Find();
		if(!empty($users->variables)){
			$_SESSION['loggedIn'] = $users->variables;
			//$this->index();
			header('Location: http://localhost/new-cbr');
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
				$user->password = md5($request['password']);
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
		$user->username = $post['params'];
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
		$user->username = $params['params'];
		$user->Find();
		$this->data['title'] = lang('Edit user');	
		$this->data['header'] = lang('Edit new user');
		$this->data['request'] = $user->variables;
		$this->view('user/edit',$this->data);
		
	}
	
	function update(){
		$request = Core::Request();
		
		if(!empty($request)){
			//$this->__validusername($request['username']);			
			$user = $this->loadmodel('UserModel');
			$user->username = $request['params'];
			if(!empty($request['password'])){
				$user->password = md5($request['password']);
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
		$user = $this->loadmodel('UserModel');
		$user->username = $username;
		$user->Find();
		
		if($user->variables){
			return false;
		} 
		
		return true;
	}
}