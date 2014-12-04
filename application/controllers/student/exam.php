<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exam extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('courses_model', 'Courses');
		$this->load->model('examprocess_model', 'examproc');

		// Permissions List for this Class
		$perm = array('admin', 'teacher', 'student');
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
		
	}

	public function doexam($paperId)
	{
		// Load Library
		$this->load->library('Fullexampaper', array('paperid'=>$paperId, 'useForm'=>true));
		// Usage
		//echo $this->fullexampaper->createExamPaper();

		/*
		   ควรเช็คว่าถึงเวลาสอบหรือไม่
		   และได้ลงวิชาไว้หรือเปล่า
		   ในที่นี้อาจไม่ทัน  จึงยังไม่ได้ Implement
		*/
		
		$coursesNum = $this->Courses->countCourseList();
		$headerData['coursesNum'] = $coursesNum;

		$this->load->view('frontend/t_header_view', $headerData);
		
		$courseId = $this->Courses->getCourseIdByPaperId($paperId);
		$courseData = $this->Courses->getCourseById($courseId);
		$data['courseData'] = $courseData;
		$data['paperid'] = $paperId;
		$data['uid'] = $this->session->userdata('uid');
		$data['formlink'] = "student/exam/submit";
		$this->load->view('student/exampaper_view', $data);

		$this->load->view('frontend/t_footer_view');
	}

	public function submit()
	{
		// Check perm
		// Check Student ID that enroll yet? or can exam this course?
		// ...
		$courseid = $this->input->post('course');
		$paperid = $this->input->post('paper');
		$answers = $this->input->post('answer');
		$examproc = $this->examproc->addScoreboard($this->session->userdata('uid'), $courseid, $paperid, $answers);
		echo $examproc;
	}

}

/* End of file student.php */
/* Location: ./application/controllers/student.php */