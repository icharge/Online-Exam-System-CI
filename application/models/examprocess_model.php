<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Examprocess_model extends CI_Model {

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

	function getCorrectAnswer($sco_id)
	{
		/*
		SELECT question_id,sco_id, answer
		FROM Answer_Papers
		WHERE answer = getAnswer(question_id)
		*/
		$query = $this->db
			->select(array('question_id','sco_id','answer'))
			->where('answer' ,'getAnswer(question_id)', false)
			->where('sco_id' ,$sco_id)
			->get('Answer_Papers');
		//die($this->db->last_query());

		// นับข้อที่ถูก
		return $query->num_rows();
	}

	/*
	 * addScoreboard
	 * เพิ่มคะแนนลง DB
	 * --------------------------
	 * uid - รหัสนิสิต
	 * courseid - รหัสวิชาเปิดสอบ
	 * paperid - รหัสชุดข้อสอบ
	 * answers - ข้อมูลคำตอบเป็น Array
	 * score - คะแนนรวม
	 */
	function addScoreboard($uid, $courseid, $paperid, $answers, $score=0, $max=null, $min=null)
	{
		$dataScoreboard = array(
			'stu_id' => $uid,
			'course_id' => $courseid,
			'paper_id' => $paperid,
			'Score' => $score,
			'Max' => $max,
			'Min' => $min,
		);
		$query = $this->db->insert('Scoreboard', $dataScoreboard);
		$newid = $this->db->insert_id();

		$answerData = array();
		foreach ($answers as $key => $value) {
			//echo "$key : $value <br>";
			$data = array(
				'question_id' => $key,
				'sco_id' => $newid,
				'answer' => $value,
			);
			array_push($answerData, $data);
		}

		if ($this->addAnswers($answerData))
		{
			$score = $this->getCorrectAnswer($newid);
		}

		$this->db->update('Scoreboard', array('score'=>$score), array('sco_id'=>$newid));

		return $score;
	}

	function addAnswers($data)
	{
		// Check error ???

		$query = $this->db->insert_batch('Answer_Papers', $data);

		return true;
	}


}

/* End of file examprocess_model.php */
/* Location: ./application/models/examprocess_model.php */