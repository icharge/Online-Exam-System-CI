<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fullexampaper
{
	protected $ci;
	private $paperId;

	public function __construct($param = array())
	{
		$this->ci =& get_instance();
		$this->ci->load->model('paperexam_model', 'paperexam');

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
			return $this->ci->paperexam->loadPaper($this->paperId);
	}



}

/* End of file fullexampaper.php */
/* Location: ./application/libraries/fullexampaper.php */
