<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * FullExamPaper -- To show full exam paper
 * Library
 */

class Fullexampaper
{
	protected $ci; // CI Instance
	protected $db; // DB Object
	private $paperId;

	public function __construct($param = array())
	{
		$this->ci =& get_instance();
		$this->db = $this->ci->db;
		// $this->ci->load->model('paperexam_model', 'paperexam');

		// Default value
		$this->paperId = '';

		if (is_array($param))
		{
			if (isset($param['paperid']))
			{
				$this->paperId = $param['paperid'];
				// echo $this->paperId;
			}

		}

	}

	public function setPaperId($value)
	{
		$this->paperId = $value;
	}

	public function createExamPaper()
	{
		$paperData = $this->_loadPaper();
		// Create View to HTML var
		$html = $paperData['title'];
		return $html;
	}

	function _loadPaper()
	{
		if ($this->paperId == '') return "Failed";
		else
			return $query = $this->db
			->get_where('Exam_Papers', array('paper_id' => $this->paperId))
			->row_array();
	}

	function _loadPart()
	{
		if ($this->paperId == '') return "Failed";
		else
			return $query = $this->db
			->get_where('Exam_Papers_Parts', array('paper_id' => $this->paperId))
			->result_array();
	}

	function _loadQuestion($partId)
	{
		// if ($partId == '') return "Failed";
		// else
		// 	return $query = $this->db
		// 	->get_where('Exam_Papers', array('paper_id' => $this->paperId))
		// 	->row_array();
	}


}

/* End of file fullexampaper.php */
/* Location: ./application/libraries/fullexampaper.php */
