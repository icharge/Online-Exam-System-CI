<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

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
		$this->load->view('admin/dashboard_view');
		$this->load->view('admin/t_footer_view');
		
	}

	function examreport()
	{
		# code...
	}

	function scorereport()
	{
		# code...
	}

	function log()
	{
		# code...
	}

	function courses()
	{
		# code...
	}

	function users($mode='viewgroup', $arg1='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_nav_view');
		$this->load->view('admin/t_beginbody_view');
		$this->load->view('admin/t_sidebar_view');
		switch ($mode) {
			case 'viewgroup':
				if ($arg1=='') $arg1="all";
				$this->_userViewgroup($arg1);
				break;
			
			default:
				# code...
				break;
		}
		$this->load->view('admin/t_footer_view');
	}

	function _userViewgroup($arg='')
	{
		$data = array(
			'group' => $arg
		);
		$this->load->view('admin/users_view',$data);
	}


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */