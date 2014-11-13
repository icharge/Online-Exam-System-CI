<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Users_model','Users');
	}

	public function index()
	{
		//if ($this->session->userdata('logged')) {
			$headerData['enableSlider'] = 1;
			$this->load->view('frontend/t_header_view', $headerData);

			$this->load->view('frontend/index_view');

			$this->load->view('frontend/t_footer_view');
		//} else {
		//	redirect('auth/login');
		//}
	}


}

/* End of file main.php */
/* Location: ./application/controllers/main.php */