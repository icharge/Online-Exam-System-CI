<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Userimporter_model extends CI_Model {


	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');

	}

	public function ImportUsersFromFile($file, $group, $options = array())
	{
		$this->load->library('simplexlsx', array('filename' => $file));
		list($cols,) = $this->simplexlsx->dimension();

		switch ($group) {
			case 'admin':
				return $this->ImportAdminUsers($options);
				break;
			
			case 'teacher':
				return $this->ImportTeacherUsers($options);
				break;

			case 'student':
				return $this->ImportStudentUsers($options);
				break;

			default:
				return false;
				break;
		}
	}

	private function ImportAdminUsers($options = array())
	{
		
	}

	private function ImportTeacherUsers($options = array())
	{

	}

	private function ImportStudentUsers($options = array())
	{
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
					$result = $this->Users->addUser("students", $userData, $studentItem);
					if ($result != 0)
					{
						return $result;
					}
					$msg .= "<p>Import $studentItem[stu_id] $studentItem[title]$studentItem[name] $studentItem[lname] completed</p>";
				}
			}

		}
		return 0;
	}

}

/* End of file userimporter_model.php */
/* Location: ./application/models/userimporter_model.php */