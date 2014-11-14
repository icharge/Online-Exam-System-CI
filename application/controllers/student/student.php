<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');

		// Permissions List for this Class
		$perm = array('student');
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
		$headerData['enableSlider'] = 1;
		$this->load->view('frontend/t_header_view', $headerData);

		$this->load->view('frontend/index_view');

		$this->load->view('frontend/t_footer_view');
	}

}

/* End of file student.php */
/* Location: ./application/controllers/student.php */