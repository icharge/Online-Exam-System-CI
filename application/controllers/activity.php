<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Activity extends CI_Controller {
	
	function index()
	{
		$data['stdnum'] = "54310104";
		$data['stdname'] = "Norrapat Nimmanee";
		$data['menu'] = array('Home','Page1','Page2');
		$data['content'] = "My first body view";
		$this->load->view('header_view', $data);
		$this->load->view('menu_view', $data);
		$this->load->view('body_view', $data);
		$this->load->view('footer_view', $data);
	}
}