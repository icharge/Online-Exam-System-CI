<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Importusers extends CI_Controller {

	// protected $ci;

	public function __construct()
	{
		parent::__construct();
		// $this->ci = $this;
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('userimporter_model', 'uimporter');

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

	// public function getInstance()
	// {
	// 	return $ci;
	// }

	public function index()
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$data['pagetitle'] = "นำเข้าผู้ใช้งาน";
		$data['pagesubtitle'] = "นักเรียน";

		if (isset($_FILES['file'])) {
			$result = $this->uimporter->ImportUsersFromFile($_FILES['file']['tmp_name'], "student");
			//$result = 0; # for Testing
			if ($result === 0)
				$data['msg_info'] = "รายชื่อถูกนำเข้าสู่ฐานข้อมูล เรียบร้อย !";
			else
				$data['msg_err'] = "เกิดข้อผิดพลาด $result";
		}
		$this->load->view('admin/usersimport_view', $data);
		// echo '<form method="post" enctype="multipart/form-data">
		// 	*.XLSX <input type="file" name="file"  />&nbsp;&nbsp;<input type="submit" value="Parse" />
		// 	</form>';
		$this->load->view('admin/t_footer_view');

	}

}

/* End of file Importusers.php */
/* Location: ./application/controllers/Importusers.php */