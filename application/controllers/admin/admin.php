<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('report_model', 'reports');
		$this->load->model('courses_model', 'courses');

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
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$data['coursecount'] = $this->courses->countCourseList('', null, 0, 'active');
		$data['qcount'] = $this->reports->getQuestionCount();
		$data['usercount'] = $this->Users->countAllUser();
		$data['testedcount'] = $this->reports->testedCount();
		$this->load->view('admin/dashboard_view', $data);
		$this->load->view('admin/t_footer_view');
	}

}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */