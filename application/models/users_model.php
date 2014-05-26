<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		
	}

	function _checkUser($username, $password)
	{
		$result = $this->db
				->where('username', $username)
				->where('password', md5($password))
				->count_all_results('users');
		return $result > 0 ? true : false;

	}

}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */