<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('subjects_model','subjects');

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
		$this->view();
	}

	public function view($value='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_nav_view');
		$this->load->view('admin/t_beginbody_view');
		$this->load->view('admin/t_sidebar_view');

		$data['subjectlist'] = $this->subjects->getSubjectList();
		$this->load->view('admin/subjects_view', $data);
		$this->load->view('admin/t_footer_view');
	}

}

/* End of file subjects.php */
/* Location: ./application/controllers/subjects.php */