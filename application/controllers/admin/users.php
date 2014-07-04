<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

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
		$this->viewgroup();
	}

	function viewgroup($group='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$this->session->set_flashdata('noAnim', true);
		if ($group=='') $group="all";
		$data['group'] = $group;
		if ($group=='all' || $group=='admin')
			$data['adminlist'] = $this->Users->getUsersByGroup('admin',$this->input->get('q'));
		if ($group=='all' || $group=='teacher')
			$data['teacherlist'] = $this->Users->getUsersByGroup('teacher',$this->input->get('q'));
		if ($group=='all' || $group=='student')
			$data['studentlist'] = $this->Users->getUsersByGroup('student',$this->input->get('q'));
		$this->load->view('admin/users_view',$data);

		$this->load->view('admin/t_footer_view');
	}

	function adduser($group='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			# on Submit
			switch ($group) {
				case 'admin':
					$data['formlink'] = 'admin/users/adduser/admin';
					$data['pagetitle'] = "เพิ่มผู้ใช้";
					$data['pagesubtitle'] = "ผู้ดูแลระบบ";
					$data['permtxt'] = "ผู้ดูแลระบบ";

					$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required|trim');
					$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
					$this->form_validation->set_rules('passwordconfirm', 'ยืนยันรหัสผ่าน', 'required');
					$this->form_validation->set_rules('fname', 'ชื่อ', 'required|trim');
					$this->form_validation->set_rules('surname', 'นามสกุล', 'required|trim');
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
						//$data['userData'] = array_merge($userData,$adminData);
						if ($this->input->post('password') != $this->input->post('passwordconfirm'))
						{
							$data['msg_error'] = 'รหัสผ่านไม่ตรงกัน';
							$this->load->view('admin/userfield_admin_view', $data);
						}
						elseif (($result = $this->Users->addUser("admins", $userData, $adminData))==0)
						{
							# Added success
							$this->session->set_flashdata('msg_info', 
								'เพิ่ม '.$userData['username'].' เรียบร้อย');
							
							//$this->users();
							redirect('admin/users');
						}
						else
						{
							# Failed
							$this->session->set_flashdata('msg_error', 
								'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$userData['username'].' ได้<br>'.$this->misc->getErrorDesc($result,'user'));
							//$this->users();
							redirect('admin/users');
						}
					}
					else
					{
						// Set user data form
						$data['userData'] = array(
							'username' => set_value('username'),
							'name' => set_value('name'),
							'lname' => set_value('surname'),
							'email' => set_value('email'),
						);
						$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
						$this->load->view('admin/userfield_admin_view', $data);
					}

					break;

				case 'teacher':
					$data['formlink'] = 'admin/users/adduser/teacher';
					$data['ptitle'] = "ผู้สอน";
					$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required|trim');
					$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
					$this->form_validation->set_rules('passwordconfirm', 'ยืนยันรหัสผ่าน', 'required');
					$this->form_validation->set_rules('fname', 'ชื่อ', 'required|trim');
					$this->form_validation->set_rules('surname', 'นามสกุล', 'required|trim');
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
					$data['formlink'] = 'admin/users/adduser/student';
					$data['ptitle'] = "นักเรียน";
					$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required|trim');
					$this->form_validation->set_rules('password', 'รหัสผ่าน', 'required');
					$this->form_validation->set_rules('passwordconfirm', 'ยืนยันรหัสผ่าน', 'required');
					$this->form_validation->set_rules('title', 'คำนำหน้า', 'required|trim');
					$this->form_validation->set_rules('fname', 'ชื่อ', 'required|trim');
					$this->form_validation->set_rules('surname', 'นามสกุล', 'required|trim');
					// $this->form_validation->set_rules('birth', 'วันเกิด', 'required');
					$this->form_validation->set_rules('gender', 'เพศ', 'required');
					$this->form_validation->set_rules('year', 'ปีการศึกษา', 'required|trim');
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
						else
						{
							$result = $this->Users->addUser("students", $userData, $studentData);

							if ($result == 0)
							{
								# Added success
								$this->session->set_flashdata('msg_info', 
									'เพิ่ม '.$userData['username'].' เรียบร้อย');
								redirect('admin/users');
							} else {
								# Failed
								$this->session->set_flashdata('msg_error', 
									'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$userData['username'].' ได้<br>'.$result);
								redirect('admin/users');
							}
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
			# Add data
			switch ($group) {
				case 'admin':
					$data['formlink'] = 'admin/users/adduser/admin';
					$data['pagetitle'] = "เพิ่มผู้ใช้";
					$data['pagesubtitle'] = "ผู้ดูแลระบบ";
					$data['permtxt'] = "ผู้ดูแลระบบ";

					// Set user data form
					$data['userData'] = array(
						'username' => set_value('username'),
						'name' => set_value('name'),
						'lname' => set_value('surname'),
						'email' => set_value('email'),
					);
					$this->load->view('admin/userfield_admin_view', $data);
					break;

				case 'teacher':
					$data['formlink'] = 'admin/users/adduser/teacher';
					$data['ptitle'] = "ผู้สอน";
					$this->load->view('admin/adduser_teacher_view', $data);
					break;

				case 'student':
					$data['formlink'] = 'admin/users/adduser/student';
					$data['ptitle'] = "ผู้เรียน";
					$this->load->view('admin/adduser_student_view', $data);
					break;
				
				default:
					# code...
					break;
			}
			
		}
		$this->load->view('admin/t_footer_view');
	}

	function view($uid='')
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');
		
		if ($this->input->post('submit'))
		{
			$this->edit($uid);
		}
		else
		{
			$role = $this->Users->getUserRoleById($uid);
			$data['userData'] = $this->Users->getUserInfoById($uid,$role);
			$data['formlink'] = 'admin/users/view/'.$data['userData']['id'];
			$data['pagetitle'] = "ข้อมูลผู้ใช้".' '.$data['userData']['name'].
														' '.$data['userData']['lname'];
			$data['pagesubtitle'] = ' ('.$this->misc->getRoleTextTh($data['userData']['role']).')';

			switch ($role) {
				case 'admin':
					$data['permtxt'] = "ผู้ดูแลระบบ";
					$this->load->view('admin/userfield_admin_view', $data);
					break;
				
				case 'teacher':
					$data['permtxt'] = "ผู้สอน";
					$this->load->view('admin/userfield_teacher_view', $data);
					break;

				case 'student':
					$data['permtxt'] = "ผู้เรียน";
					$this->load->view('admin/userfield_student_view', $data);
					break;

				default:
					# code...
					break;
			}
		}
		$this->load->view('admin/t_footer_view');
	}

	function edit($uid)
	{
		$role = $this->Users->getUserRoleById($uid);
		switch ($role) {
			case 'admin':
				$this->form_validation->set_rules('username', 'ชื่อผู้ใช้', 'required');
				$this->form_validation->set_rules('fname', 'ชื่อ', 'required');
				$this->form_validation->set_rules('surname', 'นามสกุล', 'required');
				$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
				if ($this->form_validation->run())
				{
					# Form check completed
					$userData['username'] = $this->input->post('username');
					$userData['password'] = md5($this->input->post('password'));
					$userData['role'] = "admin";
					$adminData['name'] = $this->input->post('fname');
					$adminData['lname'] = $this->input->post('surname');
					$adminData['email'] = $this->input->post('email');
					//$data['userData'] = array_merge($userData,$adminData);
					if ($this->input->post('password') != $this->input->post('passwordconfirm'))
					{
						$data['msg_error'] = 'รหัสผ่านไม่ตรงกัน';
						$this->load->view('admin/userfield_admin_view', $data);
					}
					elseif (($result = $this->Users->addUser("admins", $userData, $adminData))==0)
					{
						# Added success
						$this->session->set_flashdata('msg_info', 
							'เพิ่ม '.$userData['username'].' เรียบร้อย');
						
						//$this->users();
						redirect('admin/users');
					}
					else
					{
						# Failed
						$this->session->set_flashdata('msg_error', 
							'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$userData['username'].' ได้<br>'.$this->misc->getErrorDesc($result,'user'));
						//$this->users();
						redirect('admin/users');
					}
				}
				else
				{
					// Set user data form
					$data['userData'] = array(
						'username' => set_value('username'),
						'name' => set_value('name'),
						'lname' => set_value('surname'),
						'email' => set_value('email'),
					);
					$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
					$this->load->view('admin/userfield_admin_view', $data);
				}
				break;
			
			default:
				
				break;
		
		}
		else
		{
			$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
			$data['subjectInfo'] = $this->subjects->getSubjectById($subjectId);
			$data['subjectInfo']['code'] = $this->input->post('code');
			$data['subjectInfo']['name'] = $this->input->post('name');
			$data['subjectInfo']['shortname'] = $this->input->post('shortname');
			$data['subjectInfo']['description'] = $this->input->post('description');
			$this->load->view('admin/edit_subject_view', $data);
		}
	}
}

/* End of file users.php */
/* Location: ./application/controllers/users.php */