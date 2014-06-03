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
				$this->session->set_flashdata('noAnim', true);
				$this->_userViewgroup($arg1);
				break;
			case 'adduser':
				if ($this->input->post('submit'))
				{
					# on Submit
					switch ($arg1) {
						case 'admin':
							$data['ptitle'] = "ผู้ดูแลระบบ";
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
								$userData['username'] = $this->input->post('username');
								$userData['password'] = md5($this->input->post('password'));
								$userData['role'] = "admin";
								$adminData['name'] = $this->input->post('fname');
								$adminData['lname'] = $this->input->post('surname');
								$adminData['email'] = $this->input->post('email');
								
								if ($this->input->post('password') != $this->input->post('passwordconfirm'))
								{
									$data['msg_error'] = 'รหัสผ่านไม่ตรงกัน';
									$this->load->view('admin/adduser_admin_view', $data);
								}
								elseif ($this->Users->addUser("admins", $userData, $adminData))
								{
									# Added success
									$this->session->set_flashdata('msg_info', 
										'เพิ่ม '.$userData['username'].' เรียบร้อย');
									
									//$this->users();
									redirect('admin/users');
								} else {
									# Failed
									$this->session->set_flashdata('msg_error', 
										'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$userData['username'].' ได้');
									//$this->users();
									redirect('admin/users');
								}
							}
							else
							{
								
								$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
								$this->load->view('admin/adduser_admin_view', $data);
							}

							break;

						case 'teacher':
							$data['ptitle'] = "ผู้สอน";
							$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required');
							$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
							$this->form_validation->set_rules('passwordconfirm', 'ยืนยันรหัสผ่าน', 'required');
							$this->form_validation->set_rules('fname', 'ชื่อ', 'required');
							$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
							$this->form_validation->set_rules('faculty', 'คณะ', 'required');
							$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
							if ($this->form_validation->run())
							{
								# Form check completed
								$userData['username'] = $this->input->post('username');
								$userData['password'] = md5($this->input->post('password'));
								$userData['role'] = "teacher";
								$teacherData['name'] = $this->input->post('fname');
								$teacherData['lname'] = $this->input->post('surname');
								$teacherData['email'] = $this->input->post('email');
								$teacherData['faculty'] = $this->input->post('faculty');
								
								if ($this->input->post('password') != $this->input->post('passwordconfirm'))
								{
									$data['msg_error'] = 'รหัสผ่านไม่ตรงกัน';
									$this->load->view('admin/adduser_teacher_view', $data);
								}
								elseif ($this->Users->addUser("teachers", $userData, $teacherData))
								{
									# Added success
									$this->session->set_flashdata('msg_info', 
										'เพิ่ม '.$userData['username'].' เรียบร้อย');
									redirect('admin/users');
								} else {
									# Failed
									$this->session->set_flashdata('msg_error', 
										'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$userData['username'].' ได้');
									redirect('admin/users');
								}
							}
							else
							{
								$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
								$this->load->view('admin/adduser_teacher_view', $data);
							}
							break;

						case 'student':
							$data['ptitle'] = "นักเรียน";
							$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required');
							$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
							$this->form_validation->set_rules('passwordconfirm', 'ยืนยันรหัสผ่าน', 'required');
							$this->form_validation->set_rules('title', 'คำนำหน้า', 'required');
							$this->form_validation->set_rules('fname', 'ชื่อ', 'required');
							$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
							// $this->form_validation->set_rules('birth', 'วันเกิด', 'required');
							$this->form_validation->set_rules('gender', 'เพศ', 'required');
							$this->form_validation->set_rules('year', 'ปีการศึกษา', 'required');
							$this->form_validation->set_rules('faculty', 'คณะ', 'required');
							$this->form_validation->set_rules('branch', 'สาขา', 'required');
							$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
							if ($this->form_validation->run())
							{
								# Form check completed
								$userData['username'] = $this->input->post('username');
								$userData['password'] = md5($this->input->post('password'));
								$userData['role'] = "student";
								$studentData['stu_id'] = $this->input->post('username');
								$studentData['title'] = $this->input->post('title');
								$studentData['name'] = $this->input->post('fname');
								$studentData['lname'] = $this->input->post('surname');
								$studentData['email'] = $this->input->post('email');
								// $studentData['birth'] = $this->input->post('birth');
								$studentData['gender'] = $this->input->post('gender');
								$studentData['year'] = $this->input->post('year');
								$studentData['faculty'] = $this->input->post('faculty');
								$studentData['branch'] = $this->input->post('branch');
								
								if ($this->input->post('password') != $this->input->post('passwordconfirm'))
								{
									$data['msg_error'] = 'รหัสผ่านไม่ตรงกัน';
									$this->load->view('admin/adduser_student_view', $data);
								}
								elseif ($this->Users->addUser("students", $userData, $studentData))
								{
									# Added success
									$this->session->set_flashdata('msg_info', 
										'เพิ่ม '.$userData['username'].' เรียบร้อย');
									redirect('admin/users');
								} else {
									# Failed
									$this->session->set_flashdata('msg_error', 
										'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$userData['username'].' ได้');
									redirect('admin/users');
								}
							}
							else
							{
								$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
								$this->load->view('admin/adduser_student_view', $data);
							}
							break;
						
						default:
							# code...
							break;
					}
				} else {
					# View data
					switch ($arg1) {
						case 'admin':
							$data['ptitle'] = "ผู้ดูแลระบบ";
							$this->load->view('admin/adduser_admin_view', $data);
							break;

						case 'teacher':
							$data['ptitle'] = "ผู้สอน";
							$this->load->view('admin/adduser_teacher_view', $data);
							break;

						case 'student':
							$data['ptitle'] = "ผู้เรียน";
							$this->load->view('admin/adduser_student_view', $data);
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