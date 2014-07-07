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
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_nav_view');
		$this->load->view('admin/t_beginbody_view');
		$this->load->view('admin/t_sidebar_view');
		$msg = "";
		if (isset($_FILES['file'])) {
			
			$this->load->library('simplexlsx', array('filename' => $_FILES['file']['tmp_name']));

			// echo '<h1>Parsing Result</h1>';

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
							'gender' => ($r[1]=="นาย")?'male':'female',
							'fac_id' => (isset($r[4])) ? $r[4] : '',
							'branch_id' => (isset($r[5])) ? $r[5] : '',
							'idcard' => (isset($r[6])) ? $r[6] : '',
							'year' => (isset($r[7])) ? $r[7] : ''
						);
						// array_push($studentData, $studentItem); 
						$this->Users->addUser("students", $userData, $studentItem);
						$msg .= "<p>Import $studentItem[stu_id] $studentItem[title]$studentItem[name] $studentItem[lname] completed</p>";
					}
				}

			}
			// var_dump($studentData);
		}
		$data['result'] = $msg;
		$this->load->view('admin/import_student', $data);
		// echo '<form method="post" enctype="multipart/form-data">
		// 	*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
		// 	</form>';
		$this->load->view('admin/t_footer_view');

	}

}

/* End of file importstudent.php */
/* Location: ./application/controllers/importstudent.php */