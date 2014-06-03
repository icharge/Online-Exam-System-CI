<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importstudent extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');

		// Permissions List for this Class
		$perm = array('admin');
		// Check
		if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			redirect('auth/login');
		}
	}

	public function index()
	{
		if (isset($_FILES['file'])) {

			$this->load->library('simplexlsx', array('filename' => $_FILES['file']['tmp_name']));

			echo '<h1>Parsing Result</h1>';

			list($cols,) = $this->simplexlsx->dimension();

			// $studentData = array();
			foreach( $this->simplexlsx->rows() as $k => $r) {
				if ($k == 0) continue; // skip first row
				if (isset($r[0]))
				{
					if ($r[0] != '')
					{
						$userData = array(
							'username' => (isset($r[0])) ? $r[0] : '',
							'password' => md5($r[0]),
							'role' => 'student'
						);
						$studentItem = array(
							'stu_id' => (isset($r[0])) ? $r[0] : '',
							'title' => (isset($r[1])) ? $r[1] : '',
							'name' => (isset($r[2])) ? $r[2] : '',
							'lname' => (isset($r[3])) ? $r[3] : '',
							'faculty' => (isset($r[4])) ? $r[4] : '',
							'branch' => (isset($r[5])) ? $r[5] : '',
							'idcard' => (isset($r[6])) ? $r[6] : '',
							'title' => (isset($r[7])) ? $r[7] : ''
						);
						// array_push($studentData, $studentItem); 
						$this->Users->addUser("students", $userData, $studentItem);
						echo '<h1>Import completed</h1>';
					}
				}

			}
			// var_dump($studentData);
		}

		echo '<h1>Upload</h1>
			<form method="post" enctype="multipart/form-data">
			*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
			</form>';


	}

}

/* End of file importstudent.php */
/* Location: ./application/controllers/importstudent.php */