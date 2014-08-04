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
		if (is_array($username) || is_array($password)) return "notfound";

		$cause = array(
			'username' => $username,
			'password' => md5($password)
			);
		$query = $this->db
			->limit(1)
			->select('role')
			->get_where('users', $cause);
		if ($this->db->_error_number() > 0) return "notfound";
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
				'users.id', 'admin_id', 'role', 'username', 'name', 'lname', 
				);
			$cause = array('username' => $username);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('admins', 'admins.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->row_array();
			//die($this->db->last_query());
			return $query;
			break;
			
			case 'teacher':
			$fields = array(
				'users.id', 'tea_id', 'role', 'username', 'name', 'lname', 
				'fac_id'
				);
			$cause = array('username' => $username);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('teachers', 'teachers.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->row_array();
			return $query;
			break;

			case 'student':
			$fields = array(
				'users.id', 'stu_id', 'role', 'username', 'name', 'lname', 
				'birth', 'gender', 'year', 'fac_id', 'branch_id'
				);
			$cause = array('username' => $username);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('students', 'students.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->row_array();
			return $query;
			break;

			default:
				# code...
			break;
		}

		// Check error?
	}

	function getUserInfoById($id, $role)
	{
		switch ($role) {
			case 'admin':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 'email', 'pic', 'status'
				);
			$cause = array('users.id' => $id);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('admins', 'admins.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->row_array();
			//die($this->db->last_query());
			return $query;
			break;
			
			case 'teacher':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				'email', 'fac_id', 'pic', 'status'
				);
			$cause = array('users.id' => $id);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('teachers', 'teachers.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->row_array();
			return $query;
			break;

			case 'student':
			$fields = array(
				'users.id', 'role', 'username', 'name', 'lname', 
				'birth', 'gender', 'year', 'fac_id', 'branch_id',
				'email', 'pic', 'status'
				);
			$cause = array('users.id' => $id);
			$query = $this->db
				->limit(1)
				->select($fields)
				->join('students', 'students.id = users.id', 'LEFT')
				->get_where('users', $cause)
				->row_array();
			return $query;
			break;

			default:
				# code...
			break;
		}

		// Check error?
	}

	function getUserRoleById($UID)
	{
		$cause = array('id'=>$UID);
		$result = $this->db->select('role')->get_where('users',$cause)->row_array();
		return $result['role'];
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

	function Userfield()
	{
		return $this->misc->getMethodName()=="adduser"?'enabled':'disabled';
	}

	function isEditPage()
	{
		return $this->misc->getMethodName()=="view"?true:false;
	}

	function getUsersByGroup($group, $keyword='', $perpage=0, $offset=0)
	{
		if ($perpage=='') $perpage=0;
		if ($offset=='') $offset=0;
		settype($offset, "integer");
		settype($perpage, "integer");
		switch ($group) {
			case 'admin':
				$fields = array(
					'users.id', 'username', 'name', 'lname', 'email', 'pic', 'role', 'status',
				);
				$cause = array('role' => 'admin');
				if ($perpage > 0) $this->db->limit($perpage, $offset);
				//die(var_dump($perpage).' '.var_dump($offset));
				$query = $this->db
					->select($fields)
					->join('admins', 'admins.id = users.id', 'LEFT')
					->like("CONCAT(username,status)",$keyword,'both')
					->get_where('users',$cause);

				//die($this->db->last_query());
				return $query->result_array();
				break;
			
			case 'teacher':
				$fields = array(
					'users.id', 'role', 'username', 'name', 'lname', 
					'fac_id', 'status'
				);
				$cause = array('role' => 'teacher');
				if ($perpage > 0) $this->db->limit($perpage, $offset);
				$query = $this->db
					->select($fields)
					->join('teachers', 'teachers.id = users.id', 'LEFT')
					->like("CONCAT(username,name,lname,fac_id,status)",$keyword,'both')
					->get_where('users',$cause);

				return $query->result_array();
				break;

			case 'student':
				$fields = array(
					'users.id', 'role', 'username', 'name', 'lname', 
					'gender', 'year', 'fac_id', 'branch_id', 'status'
				);
				$cause = array('role' => 'student');
				if ($perpage > 0) $this->db->limit($perpage, $offset);
				$query = $this->db
					->select($fields)
					->join('students', 'students.id = users.id', 'LEFT')
					->like("CONCAT(username,name,lname,gender,year,fac_id,branch_id,status)",$keyword,'both')
					->get_where('users',$cause);

				return $query->result_array();
				break;

			default:
				# code...
				break;
		}
	}

	function countUsersByGroup($group, $keyword='')
	{
		//$offset = $total / $perpage * ($page-1);
		switch ($group) {
			case 'admin':
				$fields = array(
					'count(users.id) as ucount'
				);
				$cause = array('role' => 'admin');
				$query = $this->db
					->select($fields)
					->join('admins', 'admins.id = users.id', 'LEFT')
					->like("CONCAT(username,status)",$keyword,'both')
					->get_where('users',$cause)
					->row_array();
				return $query['ucount'];
				break;
			
			case 'teacher':
				$fields = array(
					'count(users.id) as ucount'
				);
				$cause = array('role' => 'teacher');
				$query = $this->db
					->select($fields)
					->join('teachers', 'teachers.id = users.id', 'LEFT')
					->like("CONCAT(username,name,lname,fac_id,status)",$keyword,'both')
					->get_where('users',$cause)
					->row_array();
				return $query['ucount'];
				break;

			case 'student':
				$fields = array(
					'count(users.id) as ucount'
				);
				$cause = array('role' => 'student');
				$query = $this->db
					->select($fields)
					->join('students', 'students.id = users.id', 'LEFT')
					->like("CONCAT(username,name,lname,gender,year,fac_id,branch_id,status)",$keyword,'both')
					->get_where('users',$cause)
					->row_array();
				return $query['ucount'];
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
		$errno = $this->db->_error_number();
		// die(var_dump($errno));
		# Get ID
		$cause = array(
			'username' => $userData['username'],
			'password' => $userData['password']
		);
		$getId = $this->db
			->limit(1)
			->select("id")
			->get_where('users', $cause)
			->row_array()['id'];
		# Insert table
		$tableData['id'] = $getId;
		$query_admin = $this->db->insert($table, $tableData);
		
		$this->db->trans_complete();
		if ($this->db->trans_status())
		{
			return 0;
		}
		else
		{
			// die(var_dump($errno));
			return $errno;
		}
	}

	function updateUser($table, $userData, $dataSet, $uid)
	{
		$this->db->trans_begin();
		if (isset($userData)) 
		{
			$query = $this->db->update('users', $userData, array('id'=>$uid));
			$errno = $this->db->_error_number();
		}
		$query = $this->db->update($table, $dataSet, array('id'=>$uid));
		$this->db->trans_complete();
		if ($this->db->trans_status())
		{
			return 0;
		}
		else
		{
			return $errno;
		}
	}

	function btnUserfield()
	{
		return $this->_getMethodName()=="adduser"?'เพิ่มผู้ใช้':'แก้ไขข้อมูล';
	}


	
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */