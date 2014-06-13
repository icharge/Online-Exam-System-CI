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

	public function view($subjectId='')
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_nav_view');
		$this->load->view('admin/t_beginbody_view');
		$this->load->view('admin/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->edit($subjectId);
		}
		else
		{

			if ($subjectId == '')
			{
				$data['subjectlist'] = $this->subjects->getSubjectList($this->input->get('q'));
				$this->load->view('admin/subjects_view', $data);
			}
			else
			{
				$data['subjectInfo'] = $this->subjects->getSubjectById($subjectId);
				$this->load->view('admin/edit_subject_view', $data);
			}
			
		}
		$this->load->view('admin/t_footer_view');
	}

	public function add()
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_nav_view');
		$this->load->view('admin/t_beginbody_view');
		$this->load->view('admin/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->form_validation->set_rules('code', 'รหัสวิชา', 'required');
			$this->form_validation->set_rules('name', 'ชื่อวิชา', 'required');
			$this->form_validation->set_rules('shortname', 'ชื่อย่อวิชา', 'required');
			$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
			if ($this->form_validation->run())
			{
				# Form check completed
				$subjectData['subject_id'] = $this->input->post('subject_id');
				$subjectData['code'] = $this->input->post('code');
				$subjectData['name'] = $this->input->post('name');
				$subjectData['shortname'] = $this->input->post('shortname');
				$subjectData['description'] = $this->input->post('description');
				
				if ($this->subjects->addSubject($subjectData))
				{
					# Add success
					$this->session->set_flashdata('msg_info', 
						'ปรับปรุง <b>'.$subjectData['code'].' '.$subjectData['name'].'</b> เรียบร้อย');
					redirect('admin/subjects');
				} else {
					# Failed
					$this->session->set_flashdata('msg_error', 
						'มีบางอย่างผิดพลาด ไม่สามารถเพิ่ม '.$subjectData['code'].' '.$subjectData['name'].' ได้');
					redirect('admin/subjects');
				}
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
		else
		{
			$this->load->view('admin/add_subject_view');
			$this->load->view('admin/t_footer_view');
		}

	}

	public function edit($subjectId)
	{
		$this->form_validation->set_rules('code', 'รหัสวิชา', 'required');
		$this->form_validation->set_rules('name', 'ชื่อวิชา', 'required');
		$this->form_validation->set_rules('shortname', 'ชื่อย่อวิชา', 'required');
		//$this->form_validation->set_rules('description', 'คำอธิบาย', 'required');
		$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
		if ($this->form_validation->run())
		{
			# Form check completed
			//$subjectData['subject_id'] = $subjectId;
			$subjectData['code'] = $this->input->post('code');
			$subjectData['name'] = $this->input->post('name');
			$subjectData['shortname'] = $this->input->post('shortname');
			$subjectData['description'] = $this->input->post('description');
			// die(var_dump($subjectData)); 
			if ($this->subjects->updateSubject($subjectData, $subjectId))
			{
				# แก้ไข success
				$this->session->set_flashdata('msg_info', 
					'ปรับปรุง <b>'.$subjectData['code'].' '.$subjectData['name'].'</b> เรียบร้อย');
				redirect('admin/subjects');
			} else {
				# Failed
				$this->session->set_flashdata('msg_error', 
					'มีบางอย่างผิดพลาด ไม่สามารถปรับปรุง '.$subjectData['code'].' '.$subjectData['name'].' ได้');
				redirect('admin/subjects');
			}
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

/* End of file subjects.php */
/* Location: ./application/controllers/subjects.php */