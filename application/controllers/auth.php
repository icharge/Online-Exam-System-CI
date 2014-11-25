<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','Users');
		$this->load->model('Courses_model', 'Courses');
		$this->load->model('misc_model', 'misc');
	}

	public function index()
	{
		redirect('main');
	}

	public function login()
	{
		$coursesNum = $this->Courses->countCourseList();
		$headerData['coursesNum'] = $coursesNum;
		$headerData['statbar'] = true;
		$headerData['title'] = "Authentication";
		$headerData['subtitle'] = "การเข้าสู่ระบบ";
		$this->load->view('frontend/t_header_view', $headerData);

		$this->load->view('frontend/login_view');

		$this->load->view('frontend/t_footer_view');
	}

	public function dologin()
	{
		# Load View
		$coursesNum = $this->Courses->countCourseList();
		$headerData['coursesNum'] = $coursesNum;
		$headerData['statbar'] = true;
		$headerData['title'] = "Authentication";
		$headerData['subtitle'] = "การเข้าสู่ระบบ";
		
		$this->load->view('frontend/t_header_view', $headerData);

		# Login Process
		$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required');
		$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
		$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
		// $this->form_validation->set_error_delimiters('<span style="color: red">', '</span>');
		if ($this->input->post('submit'))
		{
			$username = $this->input->post('username');(is_array($username)?$username=$username[0]:true);
			$password = $this->input->post('password');(is_array($password)?$password=$password[0]:true);
			if ($this->form_validation->run())
			{
				$check = $this->Users->_checkuser($username, $password);
				switch ($check) 
				{
					case 'admin':
						// Admin table ??
						$userinfo = $this->Users->_getUserInfo($username, $check);
						$data = array(
							'id' => $userinfo['id'],
							'uid' => $userinfo['admin_id'],
							'username' => $username,
							'fullname' => $userinfo['name']." ".$userinfo['lname'],
							'fname' => $userinfo['name'],
							'lname' => $userinfo['lname'],
							'role' => $userinfo['role'],
							'logged' => true
						);
						$this->session->set_userdata($data);
						redirect('admin');
						break;
					
					case 'teacher':
						$userinfo = $this->Users->_getUserInfo($username, $check);
						$data = array(
							'id' => $userinfo['id'],
							'uid' => $userinfo['tea_id'],
							'username' => $username,
							'fullname' => $userinfo['name']." ".$userinfo['lname'],
							'fname' => $userinfo['name'],
							'lname' => $userinfo['lname'],
							'faculty' => $userinfo['faculty'],
							'role' => $userinfo['role'],
							'logged' => true
						);
						$this->session->set_userdata($data);
						redirect('teacher');
						break;

					case 'student':
						$userinfo = $this->Users->_getUserInfo($username, $check);
						$data = array(
							'id' => $userinfo['id'],
							'uid' => $userinfo['stu_id'],
							'username' => $username,
							'fullname' => $userinfo['name']." ".$userinfo['lname'],
							'fname' => $userinfo['name'],
							'lname' => $userinfo['lname'],
							'birth' => $userinfo['birth'],
							'gender' => $userinfo['gender'],
							'year' => $userinfo['year'],
							'faculty' => $userinfo['faculty'],
							'branch' => $userinfo['branch'],
							'role' => $userinfo['role'],
							'logged' => true
						);
						$this->session->set_userdata($data);
						redirect('student');
						break;

					case 'notfound':
						$data['msg_error'] = 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง';
						// $this->session->set_flashdata('msg_error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
						$this->load->view('frontend/login_view', $data);
						break;

					default:
						$data['msg_error'] = 'Error';
						$this->load->view('frontend/login_view', $data);
				}
			} else {
				$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
				$this->load->view('frontend/login_view', $data);
			}
		} else {
			redirect('auth/login');
		}
		$this->load->view('frontend/t_footer_view');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('main');
	}

}

/* End of file auth.php */
/* Location: ./application/controllers/auth.php */