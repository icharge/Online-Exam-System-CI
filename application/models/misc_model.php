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

	function listCActive($page='',$useclass=true,$direction='')
	{
		$result = '';
		
		switch ($direction) {
			case 'start':
				$result = $this->startsWith($this->getClassName(),$page);
				break;

			case 'end':
				$result = $this->endsWith($this->getClassName(),$page);
				break;

			default:
				$result = ($page == $this->getClassName()?true:false);
				break;
		}

		if ($result)
		{
			return ($useclass?' class="active"':'active');
		} else {
			return "";
		}
	}

	function listCActiveAry($items,$useclass=true)
	{
		if ($this->isInClass($items))
		{
			return ($useclass?' class="active"':'active');
		}
		else
		{
			return "";
		}
	}

	function isInClass($items)
	{
		return in_array($this->getClassName(), $items);
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

	function btnUserfield()
	{
		return $this->getMethodName()=="adduser"?'เพิ่มผู้ใช้':'แก้ไขข้อมูล';
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

	function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle)
	{
		$length = strlen($needle);
		if ($length == 0) {
			return true;
		}
		return (substr($haystack, -$length) === $needle);
	}
	
	function doLog($action,$uid='')
	{
		$logData = array(
			'uid' => ($uid!='')?$uid:($this->session->userdata('uid')!="")?$this->session->userdata('uid'):'-1',
			'action' => $action,
			'ipaddress' => $_SERVER['REMOTE_ADDR'],
			'iphostname' => GetHostByName($_SERVER['REMOTE_ADDR']),
			'iplocal' => isset($_SERVER['HTTP_X_FORWARDED_FOR'])?$_SERVER['HTTP_X_FORWARDED_FOR']:'',
			'useragent' => $this->input->user_agent()
		);
		$this->db->insert('log_usage', $logData);
	}
}

/* End of file misc.php */
/* Location: ./application/models/misc.php */