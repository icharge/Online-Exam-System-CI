<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getQuestionCount()
	{
		$query = $this->db
			->select('count(question_id) as qcount')
			->get('Questions')
			->row_array();
		return $query['qcount'];
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

	function getReportCourseCalc($course_id, $paperid=null)
	{
		$criteria['course_id'] = $course_id;
		if ($paperid !== null) $criteria['paper_id'] = $paperid;
		$criteria['paper_id >='] = '0';
		$query = $this->db
			->where($criteria)
			->get('report_course_calc')
			->result_array();
		// die( $this->db->last_query());
		return $query;
	}

	function getStdScoreByPaper($paperid)
	{
		/*
			SELECT sco_id, scoreboard.stu_id, title, name, lname, course_id, paper_id, Score, getStudentGroupByCourseId(course_id, Scoreboard.stu_id) as groupname
			FROM Scoreboard
			LEFT JOIN Students ON Scoreboard.stu_id = Students.stu_id
			WHERE paper_id =  '6'
			ORDER BY scoreboard.stu_id asc
		*/
		$query = $this->db
			->select(array('sco_id','scoreboard.stu_id','title','name','lname','course_id',
				'paper_id','Score', 'getStudentGroupByCourseId(course_id, Scoreboard.stu_id) as groupname'))
			->from('Scoreboard')
			->join('Students','Scoreboard.stu_id = Students.stu_id','left')
			->where('paper_id', $paperid)
			->order_by('groupname', 'asc')
			->order_by('scoreboard.stu_id', 'asc')
			->get()
			->result_array();
		// echo $this->db->last_query();
		return $query;
	}

	function getPapersByCourseId($courseid)
	{
		$query = $this->db
			->select('*')
			->from('Exam_Papers')
			->where('course_id', $courseid)
			->get()
			->result_array();
		return $query;
	}

	function getReportByStudent($courseid)
	{
/*
SELECT stu_id, getScoreByPaperId(11,stu_id) as paper_1 FROM `Student_Enroll` WHERE `course_id` = 6
*/
		$selcol[] = "Students.stu_id";
		$selcol[] = "title";
		$selcol[] = "name";
		$selcol[] = "lname";
		foreach ($this->getPapersByCourseId($courseid) as $item) {
			$selcol[] = "getScoreByPaperId($item[paper_id],Student_Enroll.stu_id) as paper_$item[paper_id]";
		}
		$selcol[] = "getStudentGroupByCourseId(course_id, Student_Enroll.stu_id) as groupname";
		$query = $this->db
			->select($selcol)
			->join('Students','Student_Enroll.stu_id = Students.stu_id','left')
			->where('course_id', $courseid)
			->order_by('groupname', 'asc')
			->get('Student_Enroll')
			->result_array();
		return $query;
	}

	// =================
	// STUDENT's STATS
	// =================
	function getReportTestedCourses($stu_id)
	{
		$query = $this->db
			->select(array('Scoreboard.course_id','code','year','name','shortname','description'))
			->join('courseslist_view','Scoreboard.course_id = courseslist_view.course_id','left')
			->where('stu_id',$stu_id)
			->group_by('Scoreboard.paper_id')
			->get('Scoreboard')
			->result_array();
		// echo $this->db->last_query();
		return $query;
	}

	function getReportTestedPapers($stu_id, $courseid)
	{
		$query = $this->db
			->select(array('sco_id','stu_id','scoreboard.course_id','scoreboard.paper_id','papername','starttime','endtime', 'Score','average'))
			->join('report_course_calc', 'scoreboard.paper_id = report_course_calc.paper_id','left')
			->where('stu_id', $stu_id)
			->where('scoreboard.course_id', $courseid)
			->get('Scoreboard')
			->result_array();
		// echo $this->db->last_query();
		return $query;
	}

	function testedCount()
	{
		$query = $this->db
			->select('count(sco_id) as scorecount')
			->get('Scoreboard')
			->row_array();
		return $query['scorecount'];
	}

}

/* End of file report_model.php */
/* Location: ./application/models/report_model.php */