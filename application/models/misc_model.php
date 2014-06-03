<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Misc_model extends CI_Model {

	public $variable;

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

	function listActive($page='')
	{
		if ($page == $this->getMethodName())
		{
			return ' class="active"';
		} else {
			return "";
		}
	}
	function btnActive($compare1,$compare2,$classAttr='btn btn-default')
	{
		if ($compare1 == $compare2)
		{
			return $classAttr . " active";
		} else {
			return $classAttr;
		}
	}

	function getRoleTextTh($strRole)
	{
		switch ($strRole) {
			case 'admin':
				return "ผู้ดูแลระบบ";
				break;
			case 'teacher':
				return "ผู้สอน";
				break;
			case 'student':
				return "ผู้เรียน";
				break;
			
			default:
				return "ไม่มี";
				break;
		}
	}

}

/* End of file misc.php */
/* Location: ./application/models/misc.php */