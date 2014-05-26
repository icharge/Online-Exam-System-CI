<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','Users');
	}

	public function index()
	{
		if ($this->session->userdata('logged')) {
			$this->load->view('users/header_view');
			$this->load->view('users/nav_view');
			$this->load->view('users/beginbody_view');

			$this->load->view('users/index_view');

			$this->load->view('users/footer_view');
		} else {
			redirect('main/login');
		}
	}

	public function login()
	{
		$this->load->view('users/header_view');
		$this->load->view('users/nav_view');
		$this->load->view('users/beginbody_view');

		$this->load->view('users/login_view');

		$this->load->view('users/footer_view');
	}

	public function dologin()
	{
		# Load View
		$this->load->view('users/header_view');
		$this->load->view('users/nav_view');
		$this->load->view('users/beginbody_view');

		# Login Process
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_error_delimiters('<span style="color: red">', '</span>');
		if ($this->input->post('submit'))
		{
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			if ($this->form_validation->run())
			{
				$check = $this->Users->_checkuser($username, $password);
				if ($check)
				{
					$userinfo = $this->Users->_getUserInfo($username)[0];
					$data = array(
						'username' => $username,
						'fullname' => $userinfo['name']." ".$userinfo['lname'],
						'fname' => $userinfo['name'],
						'lname' => $userinfo['lname'],
						'birth' => $userinfo['birth'],
						'perm' => $userinfo['perm'],
						'logged' => true
					);
					$this->session->set_userdata($data);
					redirect('main');
				} else {
					$this->session->set_flashdata('msg_error', 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');
					$this->load->view('users/login_view');
				}
			} else {
				$this->session->set_flashdata('msg_error', 'กรุณากรอกข้อมูลให้ครบ');
				$this->load->view('users/login_view');
			}
		} else {
			redirect('users/login');
		}
		$this->load->view('users/footer_view');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect('main/login');
	}
}

/* End of file main.php */
/* Location: ./application/controllers/main.php */