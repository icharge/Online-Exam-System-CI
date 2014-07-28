<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * CSV Reader by iCharge
 *
 * Reference : http://php.net/manual/en/function.str-getcsv.php
 */

class Csvreader
{
  protected $ci;
  private $file;

	public function __construct($param)
	{
		$this->ci =& get_instance();
		$this->file = $param['filename'];
	}

	function toArray($filename='', $delimiter=',')
	{
		if ($filename == '') $filename = $this->file;

		if(!file_exists($filename) || !is_readable($filename))
			return FALSE;

		$header = NULL;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== FALSE)
		{
			while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
			{
				if(!$header)
					$header = $row;
				else
					$data[] = array_combine($header, $row);
			}
			fclose($handle);
		}
		return $data;
	}

	function toArrayUTF8($filename='')
	{
		$arr = $this->toArray($filename);
		foreach ($arr as &$r) {
			$r = explode(",", iconv('TIS-620', 'UTF-8//IGNORE', implode(",", $r)));
		}
		return $arr;
	}

}

/* End of file csvreader.php */
/* Location: ./application/libraries/csvreader.php */
