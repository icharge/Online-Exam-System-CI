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

	function listCActive($page='')
	{
		if ($page == $this->getClassName())
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

	function getShortText($str,$len=100)
	{
		if (strlen($str) > $len)
		{
			return mb_substr($str, 0, $len, 'UTF-8').' ...';
		}
		else
		{
			return $str;
		}
	}


	function getHref($uri = '')
	{
		if ( ! is_array($uri))
		{
			$site_url = ( ! preg_match('!^\w+://! i', $uri)) ? site_url($uri) : $uri;
		}
		else
		{
			$site_url = site_url($uri);
		}
		return $site_url;
	}

	function getErrorDesc($errno,$mode='')
	{
		switch ($errno) {
			case 1062:
				if ($mode=="user")
					return "ชื่อผู้ใช้มีอยู่แล้ว ไม่สามารถซ้ำได้";
				else
					return "ข้อมูลซ้ำ";
				break;
			
			default:
				return "";
				break;
		}
	}

}

/* End of file misc.php */
/* Location: ./application/models/misc.php */