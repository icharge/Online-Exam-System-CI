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
			->select('role')
			->get_where('users', $cause);
		if ($query->num_rows() > 0) {
			$ret = $query->result_array()[0]['role'];
			return $ret;
		} else {
			return "notfound";
		}
	}

	function _getUserInfo($username, $role)
	{
		switch ($role) {
			case 'admin':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				);
			$cause = array('username' => $username);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('admins', 'admins.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->result_array();
			return $query;
			break;
			
			case 'teacher':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				'faculty'
				);
			$cause = array('username' => $username);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('teachers', 'teachers.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->result_array();
			return $query;
			break;

			case 'student':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				'birth', 'gender', 'year', 'faculty', 'branch'
				);
			$cause = array('username' => $username);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('students', 'students.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->result_array();
			return $query;
			break;

			default:
				# code...
			break;
		}

		// Check error?
	}

	function _getClassName()
	{
		return $this->router->class;
	}

	function _getMethodName()
	{
		return $this->router->method;
	}

	function _checkRole($allowedRole)
	{
		return (in_array($this->session->userdata('role'), $allowedRole)) ? true : false;
	}

	function _checkLogin()
	{
		return $this->session->userdata('logged') == true ? true : false;
	}

	function getUsersByGroup($group)
	{
		switch ($group) {
			case 'admin':
			$fields = array(
				'users.id', 'username', 'role', 'status'
				);
			$cause = array('role' => 'admin');
			$query = $this->db
				->select($fields)
				->get_where('users',$cause)
				->result_array();
			return $query;
			break;
			
			case 'teacher':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				'faculty', 'status'
				);
			$cause = array('role' => 'teacher');
			$query = $this->db
				->select($fields)
				->join('teachers', 'teachers.id = users.id', 'LEFT')
				->get_where('users',$cause)
				->result_array();
			return $query;
			break;

			case 'student':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				'gender', 'year', 'faculty', 'branch', 'status'
				);
			$cause = array('role' => 'student');
			$query = $this->db
				->select($fields)
				->join('students', 'students.id = users.id', 'LEFT')
				->get_where('users',$cause)
				->result_array();
			return $query;
			break;

			default:
				# code...
			break;
		}
	}

	function addUser($table, $userData, $tableData)
	{
		# Prepare data
		// $username = $userData['username'];
		// $password = $userData['password'];
		// $passwordmd5 = md5($password);
		// $name = $userData['name'];
		// $surname = $userData['surname'];
		//$pic;

		# Users Table first
		# Transaction begin
		$this->db->trans_begin();
		# Insert Users
		$query_user = $this->db->insert('users', $userData);

		# Get ID
		$cause = array(
			'username' => $userData['username'],
			'password' => $userData['password']
		);
		$getId = $this->db
			->limit(1)
			->select("id")
			->get_where('users', $cause)
			->result_array()[0]['id'];
		# Insert table
		$tableData['id'] = $getId;
		$query_admin = $this->db->insert($table, $tableData);
		$this->db->trans_complete();
		if ($this->db->trans_status())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */