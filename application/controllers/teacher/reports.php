<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {

	private $role;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');
		$this->load->model('report_model', 'reports');

		// Permissions List for this Class
		$perm = array('admin', 'teacher');
		// Check
		if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			redirect('auth/login');
		}
		$this->role = $this->session->userdata('role');
	}

	public function index()
	{
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		// $data['formlink'] = 'teacher/reqcourse/add';
		$data['pagetitle'] = 'รายงานตามรายวิชา';
		$data['pagesubtitle'] = '';

		// SET Default Per page
		$data['perpage'] = '10';
		if ($this->input->get('perpage')!='') $data['perpage'] = $this->input->get('perpage');

		$teaid = $this->session->userdata('uid');
		$data['total'] = $this->reports->countCoursesListCount($teaid, $this->input->get('q'),null,null,$this->input->get('year'));
		$data['courseslist'] = $this->reports->getCoursesListCount($teaid, $this->input->get('q'),
			$data['perpage'],
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')),
			$this->input->get('year'));

		$this->misc->PaginationInit(
			$this->role.'/reports?perpage='.
			$data['perpage'].'&q='.$this->input->get('q'),
			$data['total'],$data['perpage']);

		$data['pagin'] = $this->pagination->create_links();

		$this->load->view('teacher/report_scores_view', $data);
		
		$this->load->view('teacher/t_footer_view');
	}

	public function bypaper($courseid)
	{
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		// $data['formlink'] = 'teacher/reqcourse/add';
		$data['pagetitle'] = 'แบบฟอร์มร้องขอวิชา';
		$data['pagesubtitle'] = '';

		$this->load->view('teacher/report_scores_view', $data);
		
		$this->load->view('teacher/t_footer_view');
	}

}

/* End of file reports.php */
/* Location: ./application/controllers/reports.php */