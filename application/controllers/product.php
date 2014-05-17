<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

	function getall()
	{
		$sql = "select * from product";
		$query = $this->db->query($sql)->result();
		print_r($query);
	}

	function insert()
	{
		$sql = "INSERT INTO product VALUES(5, 'poo5', 'e', 50, 50, 120, 20)";
		if ($this->db->query($sql)) {
			echo "Insert Success";
		} else {
			echo "Can't insert data";
		}
	}

	function update()
	{
		$sql='update product SET pro_price = 350.75 where pro_id = 5';
		if($this->db->query($sql)) {
			echo"Update Success"; 
		} else {
			echo"Can't update Data";
		}
	}

	function delete()
	{
		$sql="delete from product where pro_id = 5";
		if($this->db->query($sql)) {
			echo "Delete Success";
		} else {
			echo "Can't delete Data";
		}
	}

	function testget()
	{
		$query1 = $this->db->get('product')->result();
		$query2 = $this->db->get('product',2,0)->result();

		print_r($query1);
		echo br(3);
		print_r($query2);

		$data['query1'] = $query1;
		$data['query2'] = $query2;
		$this->load->view('testgetview',$data);
	}

	function testgetwhere()
	{
		$cause = array(
			'pro_id' => '1',
			'pro_code' => 'p001'
		);
		$query = $this->db->get_where(
			'product', $cause, 2, 0
		)->result();

		$cause = array(
			'pro_id !=' => '1',
			'pro_code LIKE' => '%p%'
		);
		$query2 = $this->db->get_where(
			'product', $cause
		)->result();

		print_r($query);
		foreach ($query2 as $row) {
			echo $row->pro_id."<br>";
		}
		echo br(2);
	}

	function testselect()
	{
		$field = "pro_id, pro_code, pro_name";
		$query = $this->db->select($field)->get('product')->result();
		print_r($query);
		echo br(2);
	}

	function testselectmin()
	{
		/*-->select min(pro_price) as minprice from product */
		$query=$this->db->select_min('pro_price','minprice')->get('product')->result();
		print_r($query);
		echo"<br><br>";
	}

	
}