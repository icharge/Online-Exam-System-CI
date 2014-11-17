<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * FullExamPaper -- To show full exam paper
 * Library
 */

class Fullexampaper
{
	protected $ci; // CI Instance
	protected $db; // DB Object
	protected $load; // Load Object
	private $paperId;
	private $template;

	public function __construct($param = array())
	{
		$this->ci =& get_instance();
		$this->db = $this->ci->db;
		$this->load = $this->ci->load;
		// $this->ci->load->model('paperexam_model', 'paperexam');
		$this->load->model('misc_model', 'misc');

		// Default value
		$this->paperId = '';
		$this->template = 'default';

		if (is_array($param))
		{
			if (isset($param['paperid']))
			{
				$this->paperId = $param['paperid'];
			}
			if (isset($param['template']))
			{
				$this->template = $param['template'];
			}

		}

	}

	public function setPaperId($value)
	{
		$this->paperId = $value;
	}

	public function templateName()
	{
		return $this->template;
	}

	public function createExamPaper()
	{
		// Create View to HTML var
		$html = '';
		// Load data
		$paperData = $this->_loadPaper();
		$partData = $this->_loadPart();

		$data['lib'] = $this;
		$data['paperData'] = $paperData;
		$data['partData'] = $partData;
		$html .= $this->load->view('exampaper/'.$this->template.'/paper_view', $data, true);

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
		if ($partId == '') return "Failed";
		else
		{
			$query = $this->db
				->select('*')
				->from('question_detail_list')
				->where(array(
					'paper_id' => $this->paperId,
					'part_id' => $partId,
				))
				->get()
				->result_array();
			return $query;
		}
		
	}

	function _makeChoiceComp($questionid, $str, $value)
	{
		$num = rand();
		$alpha = array('', 'ก.','ข.','ค.','ง.','จ.','ฉ.');
		return '
	<div class="radio">
		<div class="col-xs-1 no-padding" style="width: inherit;">
			<label style="padding-left: 0">'.
					form_radio('correct['.$questionid.']', $value, false,'class="minimal-red correct-choice" id="'.$num.'"')." "
			.'</label>
		</div>
		<label id="c'.$value.'" class="choice" style="padding-left: 12px" for="'.$num.'">
			<span class="clabel">'.$alpha[$value].'</span>
			'.$str.'
		</label>
	</div>
';
	}


}

/* End of file fullexampaper.php */
/* Location: ./application/libraries/fullexampaper.php */
