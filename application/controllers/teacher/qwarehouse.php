<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse extends CI_Controller {

	/* Scripts */
	private $scriptList;
	private $chapterManage;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');
		$this->load->model('qwarehouse_model','qwh');
		$this->load->model('subjects_model', 'subjects');

		// Permissions List for this Class
		$perm = array('admin', 'teacher');
		// Check
		if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				echo json_encode(array('error' => "Session expire, please re-login."));
				die();
			}
			else
				redirect('auth/login');
		}

		$this->chapterManage = '
	$("#chapterName").keydown(function(e) {
		if (e.which == 13)
		{
			$("#chapterAdd").trigger("click");
			e.preventDefault();
		}
	});

	$("#chapterAdd").click(function(e) {
		e.preventDefault();

		if ($.trim($("#chapterName").val()) == "") return;

		$(this).attr("disabled", "disabled")
			.removeClass("btn-success").removeClass("btn-danger")
			.find("i")
				.removeClass("fa-plus")
				.addClass("fa-spinner fa-spin");
		$("#chapterName").attr("disabled", "disabled");
		$("#chapterName").parent().removeClass("has-error");

		var oxsysAPI = "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/addChapter/").'/'.
		$this->uri->segment(4) .'/" + $.trim($("#chapterName").val());

		$.getJSON( oxsysAPI, { format: "json" })
			.done(function(data) {
				console.log("sent " + $("#chapterName").val() + " to " + oxsysAPI);
				console.log("received : " + data.return);

				if (data.error != "") {
					$("#chapterAdd").removeAttr("disabled")
						.addClass("btn-danger")
						.find("i")
							.addClass("fa-plus")
							.removeClass("fa-spinner fa-spin");
					$("#chapterName").removeAttr("disabled").focus().parent().addClass("has-error");
					var jbox = new jBox(\'Modal\', {
						width: 350,
						height: 100,
						title: \'ข้อผิดพลาด\',
						overlay: true,
						content: data.error,
					});
					jbox.open();
				}
				else
				{
					var itemlist = \'<a href="" class="list-group-item">\'+
													\'<span class=\"badge\"></span>\'+
													\'<h4 class="list-group-item-heading">\' + data.msg + \'</h4>\'+
													\'<div class="item-group-item-text"></div>\'+
													\'</a>\';

					$("#chapterList").append(itemlist);


					$("#chapterAdd").removeAttr("disabled")
						.addClass("btn-success")
						.find("i")
							.addClass("fa-plus")
							.removeClass("fa-spinner fa-spin");
					$("#chapterName").attr("disabled", "disabled");
					$("#chapterName").parent().removeClass("has-error");
					$("#chapterName").removeAttr("disabled").focus();
					$("#chapterName").val("");
				}
			})
			.fail(function(jqxhr, textStatus, error) {
				var err = textStatus + ", " + error;
				console.log("Request Failed: "+err);

				$("#chapterAdd").removeAttr("disabled")
					.addClass("btn-danger")
					.find("i")
						.addClass("fa-plus")
						.removeClass("fa-spinner fa-spin");
				$("#chapterName").removeAttr("disabled").focus().parent().addClass("has-error");

				var jbox = new jBox(\'Modal\', {
					width: 350,
					height: 100,
					title: \'ข้อผิดพลาด\',
					overlay: true,
					content: \'ไม่สามารถเพิ่มบทได้ กรุณาตรวจสอบความถูกต้อง\',
				});
				jbox.open();

			});


		console.log($("#chapterName").val());

	});


';

		$this->scriptList = array(
			'chapterManage' => $this->chapterManage,

		);
	}

	private function getAddScripts()
	{
		return $this->scriptList;
	}

	function callbackjson()
	{
		// JSON Callback with modes & arguments.

		# Simulation loading...
		sleep(1);

		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		$arg_list = func_get_args();
		switch ($arg_list[0]) {
			case 'getChapter':
				if (isset($arg_list[1]))
					echo json_encode($this->qwh->getChapterList($arg_list[1]));
				else
					echo json_encode(array('error' => "No Subject_id"));
				break;

			case 'addChapter':
				if (isset($arg_list[1]))
				{
					if (isset($arg_list[2]))
					{
						$subject_data = $this->subjects->getSubjectById($arg_list[1]);
						if (!empty($subject_data)) {
							$subject_id = $subject_data['subject_id'];
							$ret = $this->qwh->addChapter($subject_id, trim(urldecode($arg_list[2])));
							//$ret = 0; // Testing
							if ($ret == 0)
							{
								echo json_encode(array('msg' => trim(urldecode($arg_list[2])), 'return' => "Success", 'error' => ""));
							}
							else
								echo json_encode(array('error' => $ret));
						}
						else
							json_encode(array('error' => "Subject not found"));
					}
					else
						echo json_encode(array('error' => "No Name"));
				}
				else
					echo json_encode(array('error' => "No Subject_id"));
				break;

			default:
				echo json_encode(array('error' => "No Arguments"));
				break;
		}
	}

	public function index()
	{
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		$data['pagetitle'] = "คลังข้อสอบ";
		$data['pagesubtitle'] = "";
		$data['perpage'] = 10;

		$data['total'] = $this->qwh->countSubjectList($this->input->get('q'));
		$data['subjectlist'] = $this->qwh->getSubjectList($this->input->get('q'),
			$data['perpage'],
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')));

		$this->misc->PaginationInit(
			'teacher/qwarehouse?perpage='.
			$data['perpage'].'&q='.$this->input->get('q'),
			$data['total'],$data['perpage']);

		$data['pagin'] = $this->pagination->create_links();

		$this->load->view('teacher/qwarehouse_view', $data);

		$this->load->view('teacher/t_footer_view');
	}

	public function view($subjectId)
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->edit($subjectId);
		}
		else
		{
			if ($subjectId == '')
			{
				redirect('teacher/qwarehouse');
			}
			else
			{
				$data['subjectInfo'] = $this->subjects->getSubjectById($subjectId);
				if (!empty($data['subjectInfo']))
				{

					// Set page desc
					$data['formlink'] = 'teacher/qwarehouse/view/'.$subjectId;
					$data['pagetitle'] = "จัดการคลังข้อสอบ";
					$data['pagesubtitle'] = "วิชา ".$data['subjectInfo']['code']." ".$data['subjectInfo']['name'];

					$data['chapterList'] = $this->qwh->getChapterList($data['subjectInfo']['subject_id']);

					$this->load->view('teacher/field_qwarehouse_subject_view', $data);
				}
				else
				{
					show_404();
				}

			}
		}

		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view('teacher/t_footer_view', $footdata);
	}

}

/* End of file qwarehouse.php */
/* Location: ./application/controllers/qwarehouse.php */