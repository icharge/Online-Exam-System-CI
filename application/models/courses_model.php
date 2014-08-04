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

	function isEditPage()
	{
		return $this->misc->getMethodName()=="view"?true:false;
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
			->order_by('year','desc')
			->order_by('code','asc')
			->get('courseslist_view')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function getMyCourseList($teaid, $keyword='', $perpage=0, $offset=0)
	{
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$query = $this->db
			->select('*')
			->from('Teacher_Course_Detail')
			->join('courseslist_view', 'Teacher_Course_Detail.course_id = courseslist_view.course_id', 'left')
			->like("CONCAT(code,year,name,shortname,description)",$keyword,'both')
			->where(array('tea_id'=>$teaid))
			->order_by('year','desc')
			->order_by('code','asc')
			->get()
			->result_array();
			//die($this->db->last_query());
		return $query;
	}

	function countMyCourseList($teaid, $keyword='')
	{
		$fields = array(
			'count(*) as scount'
		);
		$query = $this->db
			->select($fields)
			->from('Teacher_Course_Detail')
			->join('courseslist_view', 'Teacher_Course_Detail.course_id = courseslist_view.course_id', 'left')
			->like("CONCAT(code,year,name,shortname,description)",$keyword,'both')
			->where(array('tea_id'=>$teaid))
			->get()
			->row_array();
		return $query['scount'];
	}

	function buildCourseOptions()
	{
		$subjectList = $this->getSubjectList();
		$options[''] = "-- เลือก --";
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
		$query = $this->db->update('Courses', $CourseData, array('course_id'=>$CourseId));
		// die(var_dump($query));
		// die($this->db->last_query());
		return $query;
	}

	function getTeacherlist($CourseId, $mode='incourse')
	{
		if ($mode=='incourse')
		{
			$cause = array('course_id' => $CourseId);
			$query = $this->db
				->select('t.tea_id,name,lname,fac_id,email,pic')
				->from('Teachers t')
				->join('Teacher_Course_Detail tcd', 't.tea_id = tcd.tea_id', 'left')
				->where($cause);
			$query = $this->db->get()->result_array();
			return $query;
		}
		elseif ($mode=='exclude')
		{
			$cause = array('tcd.tea_id' => NULL);
			$query = $this->db
				->select('t.tea_id,name,lname,fac_id,email,pic')
				->from('Teachers t')
				->join('(SELECT tea_id FROM Teacher_Course_Detail WHERE course_id = '.$CourseId.') tcd', 't.tea_id = tcd.tea_id', 'left')
				->where($cause);
			$query = $this->db->get()->result_array();
			// $sub = $this->subquery->start_subquery('join');
			// $sub->select('tea_id')->from('Teacher_Course_Detail')->where('course_id', $CourseId);
			//var_dump($query);die();
			return $query;
		}
		elseif ($mode=='all')
		{
			$query = $this->db
				->select('tea_id,name,lname,fac_id,email,pic')
				->from('Teachers t');
			$query = $this->db->get()->result_array();
			return $query;
		}
	}

	function updateTeacherList($CourseId, $teasId)
	{
		$data = array();

		if ($teasId == null)
		{
			$this->db->delete('Teacher_Course_Detail', 
				array('course_id' => $CourseId)); 
			return 0;
		}

		for ($i=0; $i < sizeof($teasId); $i++) { 
			$data[$i]['tea_id'] = $teasId[$i];
			$data[$i]['course_id'] = $CourseId;
		}

		$this->db->trans_begin();
		$this->db->delete('Teacher_Course_Detail', 
			array('course_id' => $CourseId)); 

		$qins = $this->db->insert_batch('Teacher_Course_Detail', $data);
		$errno = $this->db->_error_number();
		$this->db->trans_complete();
		if ($this->db->trans_status())
		{
			return 0;
		}
		else
		{
			return $errno;
		}
	}

}

/* End of file courses_model.php */
/* Location: ./application/models/courses_model.php */