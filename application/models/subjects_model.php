<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects_model extends CI_Model {

	public $variable;

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

	function getSubjectList($keyword='')
	{
		// $fields = array(
		// 	'users.id', 'username', 'role', 'status'
		// );
		// $cause = array('role' => 'admin');
		$query = $this->db
			// ->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function getSubjectById($subjectId)
	{
		$cause = array('code' => $subjectId);
		$query = $this->db
			->get_where('subjects', $cause)
			->result_array();
		return $query[0];
	}

	function addSubject($subjectData)
	{
		$query = $this->db->insert('subjects', $subjectData);
		return $query;
	}

	function updateSubject($subjectData, $subjectId)
	{
		// var_dump($subjectData);
		// echo '<br>';
		// var_dump($subjectId);
		$query = $this->db->update('subjects', $subjectData, array('code'=>$subjectId));
		// die(var_dump($query));
		// die($this->db->last_query());
		return $query;
	}

}

/* End of file subject.php */
/* Location: ./application/models/subject.php */