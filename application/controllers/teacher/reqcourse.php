<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reqcourse extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');

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

		$data['formlink'] = 'teacher/reqcourse/add';
		$data['pagetitle'] = 'แบบฟอร์มร้องขอวิชา';
		$data['pagesubtitle'] = '';


		if ($this->input->post('submit'))
		{
			$this->add($data);
		}
		else
		{
			$this->load->view('teacher/reqcourse_view', $data);
		}
		$this->load->view('teacher/t_footer_view');
	}

}

/* End of file reqcourse.php */
/* Location: ./application/controllers/reqcourse.php */