<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');
		$this->load->model('qwarehouse_model','qwh');

		// Permissions List for this Class
		$perm = array('admin', 'teacher');
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
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		$data['pagetitle'] = "คลังข้อสอบ";
		$data['pagesubtitle'] = "";

		$data['perpage'] = 10;
		$this->load->view('teacher/qwarehouse_view', $data);

		$this->load->view('teacher/t_footer_view');
	}

}

/* End of file qwarehouse.php */
/* Location: ./application/controllers/qwarehouse.php */