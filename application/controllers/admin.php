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
			case 'adduser':
				if ($this->input->post('submit'))
				{
					switch ($arg1) {
						case 'admin':
							$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required');
							$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
							$this->form_validation->set_rules('passwordconfirm', 'ยืนยันรหัสผ่าน', 'required');
							$this->form_validation->set_rules('fname', 'ชื่อ', 'required');
							$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
							$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
							//$this->form_validation->set_error_delimiters('<span style="color: red">', '</span>');
							if ($this->form_validation->run())
							{
								# Form check completed
								$arrDat['username'] = $this->input->post('username');
								$arrDat['password'] = $this->input->post('password');
								$arrDat['name'] = $this->input->post('fname');
								$arrDat['surname'] = $this->input->post('surname');
								if ($this->input->post('password') != $this->input->post('passwordconfirm'))
								{
									$data['msg_error'] = 'รหัสผ่านไม่ตรงกัน';
									$this->load->view('admin/adduser_admin_view', $data);
								}
								if ($this->Users->addUser("admins", $arrDat))
								{
									# Added success
									$this->session->set_flashdata('msg_info', 
										'เพิ่ม '.$arrDat['username'].' เรียบร้อย');
									
									//$this->users();
									redirect('admin/users');
								} else {
									# Failed
									$this->session->set_flashdata('msg_error', 
										'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$arrDat['username'].' ได้');
									//$this->users();
									redirect('admin/users');
								}
							}
							else
							{
								
								$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
								$this->load->view('admin/adduser_admin_view', $data);
								//redirect('admin/users/adduser/admin');
							}

							break;

						case 'teacher':

							break;

						case 'student':

							break;
						
						default:
							# code...
							break;
					}
				} else {
					switch ($arg1) {
						case 'admin':
							$this->load->view('admin/adduser_admin_view');
							break;

						case 'teacher':

							break;

						case 'student':

							break;
						
						default:
							# code...
							break;
					}
					
				}
			
			default:
				# code...
				break;
		}
		$this->load->view('admin/t_footer_view');
	}

	function _userViewgroup($arg='')
	{
		$data['group'] = $arg;
		if ($arg=='all' || $arg=='admin')
			$data['adminlist'] = $this->Users->getUsersByGroup('admin');
		if ($arg=='all' || $arg=='teacher')
			$data['teacherlist'] = $this->Users->getUsersByGroup('teacher');
		if ($arg=='all' || $arg=='student')
			$data['studentlist'] = $this->Users->getUsersByGroup('student');
		$this->load->view('admin/users_view',$data);
	}


}

/* End of file admin.php */
/* Location: ./application/controllers/admin.php */