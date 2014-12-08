<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stats extends CI_Controller {

	private $role;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');
		$this->load->model('report_model', 'reports');

		// Permissions List for this Class
		$perm = array('admin', 'teacher', 'student');
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
		$headerData['title'] = "Statistics";
		$headerData['subtitle'] = "สถิติผู้สอบ";

		$this->load->view('frontend/t_header_view', $headerData);


		$data['reportRows'] = $this->reports->getReportTestedCourses($this->session->userdata('uid'));

		$this->load->view('student/stats_view', $data);

		$this->load->view('frontend/t_footer_view');
	}

	// AJAX 
	public function paperscore($course_id)
	{
		$data['courseInfo'] = $this->courses->getCourseById($course_id);
		$data['reportRows'] = $this->reports->getReportTestedPapers($this->session->userdata('uid'), $course_id);
		$this->load->view('student/stats_studentscore_view', $data);

		$this->load->view('teacher/t_footer_view');
	}

}

/* End of file stats.php */
/* Location: ./application/controllers/student/stats.php */