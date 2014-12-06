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
	private $showAns;
	private $enabled;
	private $useForm;

	public function __construct($param = array())
	{
		$this->ci =& get_instance();
		$this->db = $this->ci->db;
		$this->load = $this->ci->load;
		// $this->ci->load->model('paperexam_model', 'paperexam');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');

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
			if (isset($param['showAns']))
			{
				$this->showAns = true;
			}
			else
			{
				$this->showAns = false;
			}
			if (isset($param['enabled']))
				$this->enabled = $param['enabled'];
			else
				$this->enabled = true;
			if (isset($param['useForm']))
				$this->useForm = $param['useForm'];
			else
				$this->useForm = false;
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
		$courseData = $this->ci->courses->getCourseById($paperData['course_id']);
		$data['courseData'] = $courseData;
		$data['showAns'] = $this->showAns;
		$data['enabled'] = $this->enabled;
		$data['useForm'] = $this->useForm;

		list($startdate, $starttime) = explode(' ', $paperData['starttime']);
		$paperData['startdate'] = date('d/m/Y',strtotime($startdate));
		$paperData['starttime'] = date('h:i',strtotime($starttime));

		list($enddate, $endtime) = explode(' ', $paperData['endtime']);
		$paperData['enddate'] = date('d/m/Y',strtotime($enddate));
		$paperData['endtime'] = date('h:i',strtotime($endtime));

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

	function _loadQuestion($partId, $random=0)
	{
		if ($partId == '') return "Failed";
		else
		{
			if ($random == 1) $sortby = 'RANDOM';
			else $sortby = 'asc';

			$query = $this->db
				->select('*')
				->from('question_detail_list')
				->where(array(
					'paper_id' => $this->paperId,
					'part_id' => $partId,
				))
				->order_by('no',$sortby)
				->get()
				->result_array();
			// echo $this->db->last_query();
			return $query;
		}
		
	}

	function _makeChoiceComp($questionid, $str='', $idelem='', $checked=false, $enabled=true)
	{
		$num = rand();
		if (!$enabled)
			$readonly = "disabled";
		else
			$readonly = "";
		//$alpha = array('', 'ก.','ข.','ค.','ง.','จ.','ฉ.','t'=>'ถูก','f'=>'ผิด');

		// ใช้เป็นตัวเลข  ยืดหยุ่นกว่า  เพราะอาจจะมีข้อสอบ ไทย ? อังกฤษ
		$alpha = array('', '1)','2)','3)','4)','5)','6)','t'=>'ถูก','f'=>'ผิด');
		return '
	<div class="radio">
		<div class="col-xs-1" style="width: inherit;">
			<label style="padding-left: 0">'.
					form_radio('answer['.$questionid.']', $idelem, $checked,'class="minimal-red" id="'.$num.'" '.$readonly)." "
			.'</label>
		</div>
		<label id="c'.$idelem.'" class="choice" style="padding-left: 0" for="'.$num.'">
			<span class="clabel">'.$alpha[$idelem].'</span>
			'.$str.'
		</label>
	</div>
';
	}


}

/* End of file fullexampaper.php */
/* Location: ./application/libraries/fullexampaper.php */
