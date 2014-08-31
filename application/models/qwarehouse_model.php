<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse_model extends CI_Model {

	public $variable;

	public function __construct()
	{
		parent::__construct();

	}

	function getSubjectStatus($str)
	{
		switch ($str) {
			case 'true':
				return '<i class="text-green fa fa-circle jtooltip" title="มีข้อมูล"></i>';
				break;

			case 'false':
				return '<i class="fa fa-circle-o jtooltip" title="ไม่มีข้อมูล"></i>';
				break;

			default:
				break;
		}
		return "";
	}


	function getSubjectList($keyword='', $perpage=0, $offset=0)
	{
		$fields = array(
			'subject_id', 'code', 'name', 'shortname', 'description',
			'status', 'isHasQuestion(subject_id) as hasQuestion',
		);
		// $cause = array('role' => 'admin');

		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");

		if ($perpage > 0) $this->db->limit($perpage, $offset);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->result_array();
			// die($this->db->last_query());
		return $query;
	}

	function countSubjectList($keyword='')
	{
		$fields = array(
			'count(*) as scount'
		);
		$query = $this->db
			->select($fields)
			->like("CONCAT(code,name,shortname,description)",$keyword,'both')
			->get('subjects')
			->row_array();
		return $query['scount'];
	}

	function getChapterList($subject_id)
	{
		$cause = array('subject_id' => $subject_id);
		$query = $this->db
			->get_where('chapter', $cause)
			->result_array();
		return $query;
	}

	function addChapter($subject_id, $chapterName)
	{
		$data = array(
			'name' => $chapterName,
			'subject_id' => $subject_id,
		);
		$this->db->trans_start();
			$chins = $this->db->insert('Chapter', $data);
			$newid = $this->db->insert_id();
			$errno = $this->db->_error_number();
		$this->db->trans_complete();

		return array(
			'result' => $chins,
			'id' => $newid,
			'errno' => $errno
		);
	}

	function renChapter($chapter_id, $chapterName)
	{
		$data = array(
			'name' => $chapterName,
		);
		$chupd = $this->db
							->where('chapter_id', $chapter_id)
							->update('Chapter', $data);
		return $this->db->_error_number();
	}

	function delChapter($chapter_id)
	{

		$cause = array('questions.chapter_id' => $chapter_id);
		$this->db->trans_start();
			$countChapter = $this->db
				->select("count(questions.chapter_id) as c")
				->join('questions', 'Chapter.chapter_id = questions.chapter_id', 'LEFT')
				->get_where('Chapter', $cause)
				->row_array();
			$errno = $this->db->_error_number();
		$this->db->trans_complete();

// SELECT count(q.chapter_id) as C
// FROM Chapter ch
// left join questions q on (ch.chapter_id = q.chapter_id)
// WHERE ch.chapter_id = 1

		if ($errno == 0)
		{
			if (intval($countChapter['c']) > 0)
			{
				return array(
					'result' => "Error, can't delete.",
					'msg' => "ไม่สามารถลบ Chapter ได้ เนื่องจากมีโจทย์คำถามแล้ว",
					'errno' => 0
				);
			}
			else
			{
				$this->db->trans_start();
					$delCh = $this->db->delete('Chapter', array('chapter_id' => $chapter_id));
					$errno = $this->db->_error_number();
				$this->db->trans_complete();
				if ($errno == 0)
				{
					return array(
						'result' => "deleted",
						'msg' => "ลบ Chapter เรียบร้อย",
						'errno' => 0
					);
				}
				else
				{
					return array(
						'result' => "Error, db",
						'msg' => "ข้ผิดพลาดจากฐานข้อมูล : " . $errno,
						'errno' => $errno
					);
				}
			}
		}
		else
		{
			return array(
				'result' => "Error, db",
				'msg' => "ข้ผิดพลาดจากฐานข้อมูล : " . $errno,
				'errno' => $errno
			);
		}

		$data = array(
			'name' => $chapterName,
		);
		$chupd = $this->db
							->where('chapter_id', $chapter_id)
							->update('Chapter', $data);
		return $this->db->_error_number();
	}

}

/* End of file qwarehouse_model.php */
/* Location: ./application/models/qwarehouse_model.php */