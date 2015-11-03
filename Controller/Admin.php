<?php 
class Admin extends BaseController{

	function index(){
		$data['header'] = 'Dashboard';
		if($_SESSION['loggedIn']){
			$data['title'] = "Backend";
			$data['layout'] = 'adminhtml';
			$ProblemModel = $this->loadmodel('SearchModel');
			$JurnalModel = $this->loadmodel('JurnalModel');
			$LecturerModel = $this->loadmodel('LecturerModel');
			$StudentModel = $this->loadmodel('StudentModel');
			$data['lecturer'] = $LecturerModel->count('*');
			$data['jurnal'] = $JurnalModel->count('*');
			$data['student'] = $StudentModel->count('*');
			$data['problem'] = $ProblemModel->query("SELECT count as value, term as label FROM `problems` GROUP BY `term` ORDER BY `id_problem` DESC");
			$data['problemb'] = $ProblemModel->query("SELECT count , term  FROM `problems` GROUP BY `term` ORDER BY `id_problem` DESC");
			
			// echo '<pre>';
			// print_r($data);
			// echo '</pre>';
			$data['problem'] = json_encode($data['problem']);
			$data['problemb'] = json_encode($data['problemb']);
			$this->view('admin/index',$data);
		} else {
			header('Location: http://localhost/new-cbr/user/invalid');
		}
	}
	
}