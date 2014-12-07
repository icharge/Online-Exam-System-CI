<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getCoursesListCount($teaid='', $keyword='', $perpage=0, $offset=0, $year=0)
	{
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$cause = array();
		if ($year != 0) $cause['year'] = $year;
		if ($teaid != '') $this->db->where('course_id IN', "( SELECT course_id FROM Teacher_Course_Detail WHERE tea_id = '$teaid')", false);

		$query = $this->db
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->where($cause)
			->order_by('year','desc')
			->order_by('examcount','desc')
			->order_by('code','asc')
			->get('report_courses')
			->result_array();
			// die( $this->db->last_query());
		return $query;
	}

	function countCoursesListCount($teaid='', $keyword='', $year=0)
	{

		$cause = array();
		if ($year != 0) $cause['year'] = $year;
		if ($teaid != '') $this->db->where('course_id IN', "( SELECT course_id FROM Teacher_Course_Detail WHERE tea_id = '$teaid')", false);

		$query = $this->db
			->select("count(*) as scount")
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->where($cause)
			->get('report_courses')
			->row_array();
		return $query['scount'];
	}

	function getReportCourseCalc($course_id)
	{
		$query = $this->db
			->where('course_id', $course_id)
			->get('report_course_calc')
			->result_array();
		return $query;
	}

	function getStdScoreByPaper($paperid)
	{
		$query = $this->db
			->where('paper_id', $paperid)
			->order_by('stu_id', 'asc')
			->get('Scoreboard')
			->result_array();
		return $query;
	}

}

/* End of file report_model.php */
/* Location: ./application/models/report_model.php */