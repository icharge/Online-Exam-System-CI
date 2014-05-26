<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function _checkUser($username, $password)
	{
		/*
		$result = $this->db
				->where('username', $username)
				->where('password', md5($password))
				->count_all_results('users');
		return $result > 0 ? true : false;
		*/

		$cause = array(
			'username' => $username,
			'password' => md5($password)
		);
		$query = $this->db
			->limit(1)
			->select('perm')
			->get_where('users', $cause);
		if ($query->num_row() > 0) {
			$ret = $query->result_array()[0]['perm'];
			return $ret;
		} else {
			return "notfound";
		}
	}

	function _getUserInfo($username)
	{
		$fields = array('users.id', 'perm', 'username', 'name', 'lname', 'birth', 'faculty');
		$cause = array('username' => $username);
		$query = $this->db
			->limit(1)
			->select($fields)
			->join('students', 'students.id = users.id', 'LEFT')
			->get_where('users', $cause)
			->result_array();
		return $query;
	}

}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */