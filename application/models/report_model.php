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

		$query = $this->db
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			// ->where(array('tea_id'=>$teaid))
			->where($cause)
			->order_by('year','desc')
			->order_by('examcount','desc')
			->order_by('code','asc')
			->get('report_courses')
			->result_array();
			// die( $this->db->last_query());
		return $query;
	}

	function countCoursesListCount($teaid='', $keyword='', $perpage=0, $offset=0, $year=0)
	{
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$cause = array();
		if ($year != 0) $cause['year'] = $year;

		$query = $this->db
			->select("count(*) as scount")
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			// ->where(array('tea_id'=>$teaid))
			->where($cause)
			->get('report_courses')
			->row_array();
		return $query['scount'];
	}

}

/* End of file report_model.php */
/* Location: ./application/models/report_model.php */