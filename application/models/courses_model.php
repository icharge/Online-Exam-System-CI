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
		return $this->getMethodName()=="add"?'เพิ่มข้อมูล':'บันทึก';
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

	function buildPapersOptions($courseId)
	{
		$paperList = $this->getStudentGroups($courseId);
		$options[''] = "-- เลือก --";
		foreach ($paperList as $item) {
			$options[$item['group_id']] = $item['name'];
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

	function getStudentlist($CourseId, $mode='incourse', $groupId='')
	{
		if ($mode=='incourse')
		{
			$cause = array('course_id' => $CourseId);
			if ($groupId != '') $cause['group_id'] = $groupId;
			$query = $this->db
				->select('stu.stu_id,title,name,lname,birth,gender,idcard,year,fac_id,branch_id,email,pic')
				->from('students stu')
				->join('Student_Enroll stuen', 'stu.stu_id = stuen.stu_id', 'left')
				->where($cause);
			$query = $this->db->get()->result_array();
			return $query;
		}
		elseif ($mode=='exclude')
		{
			$cause = array('stuen.stu_id' => NULL);
			$query = $this->db
				->select('stu.stu_id,title,name,lname,birth,gender,idcard,year,fac_id,branch_id,email,pic')
				->from('Students stu')
				->join('(SELECT stu_id FROM Student_Enroll WHERE course_id = '.$CourseId.') stuen', 'stu.stu_id = stuen.stu_id', 'left')
				->where($cause);
			$query = $this->db->get()->result_array();
			return $query;
		}
		elseif ($mode=='all')
		{
			$query = $this->db
				->select('*')
				->from('Students');
			$query = $this->db->get()->result_array();
			return $query;
		}
	}

	function updateStudentList($groupId, $CourseId, $stdId)
	{
		$data = array();

		if ($stdId == null)
		{
			$this->db->delete('Student_Enroll',
				array('course_id' => $CourseId, 'group_id' => $groupId));
			return 0;
		}

		for ($i=0; $i < sizeof($stdId); $i++) {
			$data[$i]['group_id'] = $groupId;
			$data[$i]['stu_id'] = $stdId[$i];
			$data[$i]['course_id'] = $CourseId;
		}

		$this->db->trans_begin();
		$this->db->delete('Student_Enroll',
			array('course_id' => $CourseId,
						'group_id' => $groupId));

		$qins = $this->db->insert_batch('Student_Enroll', $data);
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

	function getStudentGroups($CourseId)
	{
		$cause = array('course_id' => $CourseId);
		$query = $this->db
			->get_where('Course_Students_group', $cause)
			->result_array();
		return $query;
	}

	function countStudentInGroup($groupId, $CourseId = '')
	{
		$cause['group_id'] = $groupId;
		if ($CourseId != '') $cause['course_id'] = $CourseId;
		$query = $this->db
			->select('count(stu_id) as scount')
			->get_where('Student_Enroll', $cause)
			->row_array();
		return $query['scount'];
	}

	function countStudentInCourse($CourseId)
	{
		// SELECT count(stu_id) as countstd FROM `Student_Enroll` WHERE course_id = '1'
		$cause['course_id'] = $CourseId;
		$query = $this->db
			->select('count(stu_id) as countstd')
			->get_where('Student_Enroll', $cause)
			->row_array();
		return $query['countstd'];
	}

	function addStudentGroup($CourseId, $gname, $gdesc)
	{
		$data = array(
			'name' => $gname,
			'description' => $gdesc,
			'course_id' => $CourseId,
		);
		$query = $this->db->insert('Course_Students_group', $data);
		$newid = $this->db->insert_id();
		return array(
			'result' => 'ok',
			'newid' => $newid,
			'name' => $gname,
			'desc' => $gdesc,
			'error' => $this->db->_error_number(),
		);
	}

	function deleteStudentGroup($groupId)
	{
		$query = $this->db->delete('Course_Students_group',
			array('group_id' => $groupId));
		$errno = $this->db->_error_number();
		return ($errno == 0?"ok":$errno);
	}

	function getExamPapersList($course_id, $keyword='')
	{
		$fields = array(
			'paper_id', 'title', 'description', 'rules', 'starttime', 'endtime', 'course_id'
		);
		$query = $this->db
			->select($fields)
			->from('Exam_Papers')
			->like("CONCAT(title,description,rules,starttime,endtime)",$keyword,'both')
			->where(array('course_id'=>$course_id))
			->get()
			->result_array();
		return $query;
	}

	function addPaper($paperData)
	{

		$query = $this->db->insert('Exam_Papers', $paperData);
		$newid = $this->db->insert_id();
		return array(
			'result' => 'ok',
			'newid' => $newid,
			'name' => $paperData['title'],
			'error' => $this->db->_error_number(),
		);
	}

	function getExamPaperParts($paperid)
	{
		$cause = array('paper_id' => $paperid);
		$query = $this->db
			->order_by('no','asc')
			->get_where('Exam_Papers_Parts', $cause)
			->result_array();
		return $query;
	}

	function addPart($partData)
	{

		$query = $this->db->insert('Exam_Papers_Parts', $partData);
		$newid = $this->db->insert_id();
		return array(
			'result' => 'ok',
			'newid' => $newid,
			'name' => $partData['title'],
			'error' => $this->db->_error_number(),
		);
	}

	function getPartInfoById($partId)
	{
		$cause = array('part_id' => $partId);
		$query = $this->db
			->get_where('Exam_Papers_Parts', $cause)
			->row_array();
		return $query;
	}

	function getCourseIdFromPartId($partId)
	{
		$query = $this->db
			->select("course_id")
			->from('Exam_Papers_Parts')
			->join('Exam_Papers', 'Exam_Papers_Parts.paper_id = Exam_Papers.paper_id', 'left')
			->where(array('Exam_Papers_Parts.part_id'=>$partId))
			->limit(1)
			->get()
			->row_array();
		return $query['course_id'];
	}

	function updatePartOrder($partData)
	{
		foreach ($partData as $key => $value) {
			$query = $this->db->update('Exam_Papers_Parts', array('no'=>$key+1), array('part_id'=>$value));
		}
	}

	function getUpcomingTest($stdId)
	{
		/*
		SELECT * FROM Student_Enroll se
		LEFT JOIN Exam_papers ep on se.course_id = ep.course_id
		WHERE stu_id = '$stdId' and starttime >= now()
		*/
		$query = $this->db
			->select("*")
			->from('Student_Enroll')
			->join('Exam_Papers', 'Exam_Papers.course_id = Student_Enroll.course_id', 'left')
			->where(array(
				'stu_id' => $stdId, 
				'starttime' => 'now()'
			))
			->get()
			->row_array();
		return $query;
	}

}

/* End of file courses_model.php */
/* Location: ./application/models/courses_model.php */