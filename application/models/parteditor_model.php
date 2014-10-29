<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parteditor_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

	}

	function getQuestionList($chapterid)
	{
		/*
		SELECT * FROM question_list q 
		LEFT JOIN Exam_Papers_Detail epd on q.question_id = epd.question_id 
		WHERE epd.question_id IS NULL 
		ORDER BY `q`.`question_id` ASC
		*/

		$query = $this->db
			->select("*")
			->from('question_list')
			->join('Exam_Papers_Detail', 
				'question_list.question_id = Exam_Papers_Detail.question_id', 'left')
			->where(array(
				'question_list.question_id'=>NULL,
				'question_list.chapter_id'=>$chapterid
			))
			->get()
			->row_array();
		return $query;
	}

}

/* End of file parteditor_model.php */
/* Location: ./application/models/parteditor_model.php */