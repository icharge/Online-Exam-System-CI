<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subjects_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	function getSubjectList()
	{
		// $fields = array(
		// 	'users.id', 'username', 'role', 'status'
		// );
		// $cause = array('role' => 'admin');
		$query = $this->db
			// ->select($fields)
			->get('subjects')
			->result_array();
		return $query;
	}

}

/* End of file subject.php */
/* Location: ./application/models/subject.php */