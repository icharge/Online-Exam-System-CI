<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse extends CI_Controller {

	/* Scripts */
	private $scriptList;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');
		$this->load->model('qwarehouse_model','qwh');
		$this->load->model('subjects_model', 'subjects');

		// Permissions List for this Class
		$perm = array('admin', 'teacher');
		// Check
		if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			redirect('auth/login');
		}



		$this->scriptList = array(

		);
	}

	private function getAddScripts()
	{
		return $this->scriptList;
	}


	public function index()
	{
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		$data['pagetitle'] = "คลังข้อสอบ";
		$data['pagesubtitle'] = "";
		$data['perpage'] = 10;

		$data['total'] = $this->qwh->countSubjectList($this->input->get('q'));
		$data['subjectlist'] = $this->qwh->getSubjectList($this->input->get('q'),
			$data['perpage'],
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')));

		$this->misc->PaginationInit(
			'teacher/qwarehouse?perpage='.
			$data['perpage'].'&q='.$this->input->get('q'),
			$data['total'],$data['perpage']);

		$data['pagin'] = $this->pagination->create_links();

		$this->load->view('teacher/qwarehouse_view', $data);

		$this->load->view('teacher/t_footer_view');
	}

	public function view($subjectId)
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->edit($subjectId);
		}
		else
		{
			if ($subjectId == '')
			{
				redirect('teacher/qwarehouse');
			}
			else
			{
				$data['subjectInfo'] = $this->subjects->getSubjectById($subjectId);
				if (!empty($data['subjectInfo']))
				{

					// Set page desc
					$data['formlink'] = 'teacher/qwarehouse/view/'.$subjectId;
					$data['pagetitle'] = "จัดการคลังข้อสอบ";
					$data['pagesubtitle'] = "วิชา ".$data['subjectInfo']['code']." ".$data['subjectInfo']['name'];

					$data['chapterList'] = $this->qwh->getChapterList($data['subjectInfo']['subject_id']);

					$this->load->view('teacher/field_qwarehouse_subject_view', $data);
				}
				else
				{
					show_404();
				}

			}
		}

		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view('teacher/t_footer_view', $footdata);
	}

}

/* End of file qwarehouse.php */
/* Location: ./application/controllers/qwarehouse.php */