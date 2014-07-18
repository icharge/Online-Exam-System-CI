<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function getClassName()
	{
		return $this->router->class;
	}

	function getMethodName()
	{
		return $this->router->method;
	}

	function btnSaveText()
	{
		return $this->getMethodName()=="add"?'เพิ่มข้อมูล':'แก้ไขข้อมูล';
	}

	function getSubjectList($status = '')
	{
		$query = $this->db
			// ->select($fields)
			->like("status",$status)
			->get('subjects')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function getSubjectDesc($subject_id)
	{
		$query = $this->db
			->select("description")
			->get_where('subjects', array('subject_id'=>$subject_id))
			->row_array();
		return $query;
	}

	function getCourseList($keyword='', $perpage=0, $offset=0)
	{
// SELECT course_id, year, tea_id, startdate, name, shortname, description, visible, enabled 
// FROM Course c 
// LEFT JOIN Subjects s on (c.subject_id = s.subject_id) 
// WHERE 1
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$query = $this->db
			// ->select($fields)
			->like("CONCAT(code,year,name,shortname,description)",$keyword,'both')
			->get('courseslist_view')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function buildCourseOptions()
	{
		$subjectList = $this->getSubjectList();
		$options['-1'] = "-- เลือก --";
		foreach ($subjectList as $item) {
			$options[$item['subject_id']] = $item['code']." — ".$item['name'];
		}
		return $options;
	}

	function countCourseList($keyword='')
	{
		$fields = array(
			'count(*) as scount'
		);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,year,name,shortname,description)",$keyword,'both')
			->get('courseslist_view')
			->row_array();
		return $query['scount'];
	}

	function getCourseById($CourseId)
	{
		$cause = array('course_id' => $CourseId);
		$query = $this->db
			->get_where('courseslist_view', $cause)
			->result_array();
		return $query[0];
	}

	function addCourse($CourseData)
	{
		$query = $this->db->insert('Courses', $CourseData);
		return $query;
	}

	function updateCourse($CourseData, $CourseId)
	{
		// var_dump($CourseData);
		// echo '<br>';
		// var_dump($CourseId);
		$query = $this->db->update('Courses', $CourseData, array('code'=>$CourseId));
		// die(var_dump($query));
		// die($this->db->last_query());
		return $query;
	}

}

/* End of file courses_model.php */
/* Location: ./application/models/courses_model.php */