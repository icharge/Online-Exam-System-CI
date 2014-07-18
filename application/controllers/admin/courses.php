<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	private $subjectDropdownScript;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
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

		// Prepare JavaScript !!
		$this->subjectDropdownScript = "
$('#subjectid').change(function(){
	if($(this).val() == '-1')
	{
		$('#courseDesc').html('<h4>...กรุณาเลือกวิชา...<h4>');
	}
	else
	{
		$('#courseDesc').html('<h4><b><i class=\"fa fa-spinner fa-spin\"></i> กำลังโหลด...</b></h4>');
		var oxsysAPI = \"".$this->misc->getHref('admin/courses/callbackjson/getSubjectDesc/')."/\" + $(this).val();
		$.getJSON( oxsysAPI, { format: \"json\" })
			.done(function(data) {
				$('#courseDesc').html(data.description);
			})
			.fail(function(jqxhr, textStatus, error) {
				var err = textStatus + \", \" + error;
				console.log(\"Request Failed: \"+err);
			});
	}
});
";
	}

	public function index()
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		// SET Default Per page
		$data['perpage'] = '10';
		if ($this->input->get('perpage')!='') $data['perpage'] = $this->input->get('perpage');

		$data['total'] = $this->courses->countCourseList($this->input->get('q'));
		$data['courseslist'] = $this->courses->getCourseList($this->input->get('q'),
			$data['perpage'], 
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')));

		$this->misc->PaginationInit(
			'admin/courses?perpage='.
			$data['perpage'].'&q='.$this->input->get('q'),
			$data['total'],$data['perpage']);

		$data['pagin'] = $this->pagination->create_links();

		
		$this->load->view('admin/courses_view', $data);
		$this->load->view('admin/t_footer_view');
	}

	public function view($courseId='')
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->edit($courseId);
		}
		else
		{
			if ($courseId == '')
			{
				redirect('admin/courses');
			}
			else
			{
				$data['courseInfo'] = $this->courses->getCourseById($courseId);
				$data['formlink'] = 'admin/course/view/'.$courseId;
				$data['pagetitle'] = "ข้อมูลการเปิดสอบ";
				$data['pagesubtitle'] = $data['courseInfo']['code']." ".$data['courseInfo']['name'];
				$this->load->view('admin/field_course_view', $data);
			}
		}

		$footdata['additionScript'] = array(
			'subjectDropdownScript' => $this->subjectDropdownScript,
		);
		$this->load->view('admin/t_footer_view', $footdata);
	}

	public function add()
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$data['formlink'] = 'admin/subjects/add';
		$data['pagetitle'] = "เพิ่มวิชา";
		$data['pagesubtitle'] = "ในระบบ";
		$data['subjectInfo'] = array(
			'code' => set_value('code'),
			'name' => set_value('name'),
			'shortname' => set_value('shortname'),
			'description' => set_value('description'),
		);

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
				//$data['subjectInfo'] = $this->subjects->getSubjectById($courseId);
				$data['subjectInfo']['code'] = $this->input->post('code');
				$data['subjectInfo']['name'] = $this->input->post('name');
				$data['subjectInfo']['shortname'] = $this->input->post('shortname');
				$data['subjectInfo']['description'] = $this->input->post('description');
				$this->load->view('admin/field_subject_view', $data);
			}
		}
		else
		{
			$this->load->view('admin/field_subject_view', $data);
			$this->load->view('admin/t_footer_view');
		}
	}

	public function edit($courseId)
	{
		$this->form_validation->set_rules('code', 'รหัสวิชา', 'required');
		$this->form_validation->set_rules('name', 'ชื่อวิชา', 'required');
		$this->form_validation->set_rules('shortname', 'ชื่อย่อวิชา', 'required');
		//$this->form_validation->set_rules('description', 'คำอธิบาย', 'required');
		$this->form_validation->set_message('required', 'คุณต้องกรอก %s');
		if ($this->form_validation->run())
		{
			# Form check completed
			//$subjectData['subject_id'] = $courseId;
			$subjectData['code'] = $this->input->post('code');
			$subjectData['name'] = $this->input->post('name');
			$subjectData['shortname'] = $this->input->post('shortname');

			// HTMLPurifier
			require_once 'application/libraries/htmlpurifier/HTMLPurifier.auto.php';
			$purifier = new HTMLPurifier();
			$clean_html = $purifier->purify($this->input->post('description'));

			$subjectData['description'] = $clean_html;
			// die(var_dump($subjectData)); 
			if ($this->subjects->updateSubject($subjectData, $courseId))
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
			$data['subjectInfo'] = $this->subjects->getSubjectById($courseId);
			$data['formlink'] = 'admin/subjects/view/'.$data['subjectInfo']['code'];
			$data['pagetitle'] = "รายละเอียดวิชา ".$data['subjectInfo']['code']." ".$data['subjectInfo']['name'];
			$data['pagesubtitle'] = "";
			
			$data['subjectInfo']['code'] = $this->input->post('code');
			$data['subjectInfo']['name'] = $this->input->post('name');
			$data['subjectInfo']['shortname'] = $this->input->post('shortname');
			$data['subjectInfo']['description'] = $this->input->post('description');
			$this->load->view('admin/field_subject_view', $data);
		}
	}

	function callbackjson()
	{
		// JSON Callback with modes & arguments.

		# Simulation loading...
		sleep(1);

		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		$arg_list = func_get_args();
		switch ($arg_list[0]) {
			case 'getSubjectDesc':
				if (isset($arg_list[1]))
					echo json_encode($this->courses->getSubjectDesc($arg_list[1]));
				else
					echo json_encode(array('error' => "No Subject_id"));
				break;
			
			default:
				echo json_encode(array('error' => "No Arguments"));
				break;
		}
	}
	
}

/* End of file courses.php */
/* Location: ./application/controllers/courses.php */