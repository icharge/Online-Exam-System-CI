<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('courses_model', 'courses');
		$this->load->model('misc_model', 'misc');

		// Permissions List for this Class
		//$perm = array('admin', 'teacher', 'student');
		// Check
		/*if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			redirect('auth/login');
		}*/
	}

	public function index()
	{
		$coursesNum = $this->courses->countCourseList();
		$headerData['statbar'] = false;
		$headerData['coursesNum'] = $coursesNum;
		$headerData['title'] = "Courses";
		$headerData['subtitle'] = "วิชาที่เปิดสอบ";
		$this->load->view('frontend/t_header_view', $headerData);


		// SET Default Per page
		$data['perpage'] = '8';

		$data['total'] = $this->courses->countCourseList($this->input->get('q'));
		$data['courseslist'] = $this->courses->getCourseList($this->input->get('q'),
			$data['perpage'],
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')));

		$paginconfig['full_tag_open'] = '<div class="pagination text-center"><ul>';
		$paginconfig['full_tag_close'] = '</ul></div>';

		$this->misc->PaginationInit(
			'courses?q='.$this->input->get('q'),
			$data['total'],$data['perpage'], 3,
			$paginconfig
			);

		$data['pagin'] = $this->pagination->create_links();

		$this->load->view('frontend/courses_view', $data);

		$this->load->view('frontend/t_footer_view');
	}

	public function upcoming()
	{
		
	}

	public function view($courseId)
	{

	}

}

/* End of file courses.php */
/* Location: ./application/controllers/courses.php */