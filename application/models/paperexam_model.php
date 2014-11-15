<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paperexam_model extends CI_Model {

	function loadPaper($paperid)
	{
		$query = $this->db
			->get_where('Exam_Papers', array('paper_id' => $paperid))
			->row_array();
		return $query;
	}

}

/* End of file paperexam_model.php */
/* Location: ./application/models/paperexam_model.php */