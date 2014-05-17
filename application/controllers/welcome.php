<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

	public function hello()
	{
		echo "hello";
	}

	public function world($name=null)
	{
		echo "hello $name";
	}

	/**
	* Private function สามารถใช้ชื่อนำหน้าด้วย _  หรือ private function
	*/
	function _mine()
	{
		echo "This is private function";
	}

	private function mine()
	{
		echo "This is private funtion too!";
	}

	function hello2()
	{
		$this->load->view('hello_view');
	}

	function template1()
	{
		$this->load->view('head_view');
		$this->load->view('body_view');
		$this->load->view('foot_view');
	}

	function user()
	{
		$data['name'] = "Norrapat Nimmanee";
		$data['email'] = "charge_n@hotmail.com";
		$this->load->view('user_view',$data);
	}

	function user2() {
		$data['users'] = array('Uraiwan','si','Buatoom');
		$this->load->view('user2_view',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */