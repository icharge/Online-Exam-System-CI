<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Teacher extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');

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
		$this->load->view('teacher/t_nav_view');
		$this->load->view('teacher/t_beginbody_view');
		$this->load->view('teacher/t_sidebar_view');
		$this->load->view('teacher/index_view');
		$this->load->view('teacher/t_footer_view');
	}

}

/* End of file teacher.php */
/* Location: ./application/controllers/teacher.php */