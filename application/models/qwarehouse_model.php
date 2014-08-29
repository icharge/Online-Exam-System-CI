<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	function getSubjectStatus($str)
	{
		switch ($str) {
			case 'true':
				return '<i class="text-green fa fa-circle jtooltip" title="มีข้อมูล"></i>';
				break;

			case 'false':
				return '<i class="fa fa-circle-o jtooltip" title="ไม่มีข้อมูล"></i>';
				break;

			default:
				break;
		}
		return "";
	}


	function getSubjectList($keyword='', $perpage=0, $offset=0)
	{
		$fields = array(
			'subject_id', 'code', 'name', 'shortname', 'description',
			'status', 'isHasQuestion(subject_id) as hasQuestion',
		);
		// $cause = array('role' => 'admin');

		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function countSubjectList($keyword='')
	{
		$fields = array(
			'count(*) as scount'
		);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->row_array();
		return $query['scount'];
	}

	function getChapterList($subject_id)
	{
		$cause = array('subject_id' => $subject_id);
		$query = $this->db
			->get_where('chapter', $cause)
			->result_array();
		return $query;
	}

	function addChapter($subject_id, $chapterName)
	{
		$data = array(
			'name' => $chapterName,
			'subject_id' => $subject_id,
		);
		$chins = $this->db->insert('Chapter', $data);
		return $this->db->_error_number();
	}

}

/* End of file qwarehouse_model.php */
/* Location: ./application/models/qwarehouse_model.php */