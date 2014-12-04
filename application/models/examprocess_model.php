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

	function countCorrectAnswer(sco_id)
	{
		/*
		SELECT question_id,sco_id, answer, getAnswer(question_id) as correct 
		FROM `Answer_Papers` 
		WHERE answer = getAnswer(question_id)
		*/
		
	}


}

/* End of file examprocess_model.php */
/* Location: ./application/models/examprocess_model.php */