<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Qwarehouse extends CI_Controller {

	/* Scripts */
	private $scriptList;
	private $chapterManage;
	private $questionManage;

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

	$("#chapterAdd").on("click", function(e) {
		e.preventDefault();

		if ($.trim($("#chapterName").val()) == "") return;

		$(this).attr("disabled", "disabled")
			.removeClass("btn-success").removeClass("btn-danger")
			.find("i")
				.removeClass("fa-plus")
				.addClass("fa-spinner fa-spin");
		$("#chapterName").attr("disabled", "disabled");
		$("#chapterName").parent().removeClass("has-error");

		if (!Date.now) {
			Date.now = function() { return new Date().getTime(); };
		}
		var oxsysAPI = "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/addChapter/").'/?ts="+Date.now();
		var myData = {"subject_id":"'.$this->uri->segment(4).'","chapterName":$.trim($(\'#chapterName\').val())};
		//myData.push({"name":"subject_id", "value":"'.$this->uri->segment(4).'"});
		//myData.push({"name":"chapterName", "value":$.trim($(\'#chapterName\').val())});

		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
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
				var itemlist = $(\'<li class="list-group-item" data-chapter-id="\' + data.id + \'">\'+
												\'<span class=\"badge\"></span>\'+
												\'<div class=\"optionlinks\">\'+
													\'<a href=\"#edit\">\'+
														\'<i class=\"fa fa-edit\"></i>\'+
													\'</a>\'+
													\'<a href=\"#remove\" class=\"text-danger\">\'+
														\'<i class=\"glyphicon glyphicon-remove\"></i>\'+
													\'</a>\'+
												\'</div>\'+
												\'<h4 class="list-group-item-heading">\' + data.msg + \'</h4>\'+
												\'<div class="item-group-item-text"></div>\'+
												\'</li>\');

				$("#chapterList").append(itemlist);
				itemlist.hide();
				itemlist.slideDown();

				$("#chapterAdd").removeAttr("disabled")
					.addClass("btn-success")
					.find("i")
						.addClass("fa-plus")
						.removeClass("fa-spinner fa-spin");
				$("#chapterName").attr("disabled", "disabled");
				$("#chapterName").parent().removeClass("has-error");
				$("#chapterName").removeAttr("disabled").focus();
				$("#chapterName").val("");

				// Attach new selector
				$("#chapterList .list-group-item:last-child .list-group-item-heading").editable(editoptions);
				$("#chapterList .list-group-item:last-child .list-group-item-heading").on("shown", function(e, editable) {
					var par = $(this).parent();
					par.find(".optionlinks").hide();
					par.find(".badge").hide();
				});
				$("#chapterList .list-group-item:last-child .list-group-item-heading").on("hidden", function(e, reason) {
					var par = $(this).parent();
					par.find(".optionlinks").removeAttr("style");
					par.find(".badge").removeAttr("style");
				});
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
	});

	$.fn.editable.defaults.mode = "inline";
	var editoptions = {
		type: "text",
		name: "name",
		pk: function() {
			var id = $(this).parent().attr("data-chapter-id");
			return id;
		},
		url: "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/renChapter/").'/",
		tpl: \'<input type="text" style="width: 100%">\',

	};

	$("#chapterList .list-group-item .list-group-item-heading").editable(editoptions);

	$("#chapterList .list-group-item .list-group-item-heading").on("shown", function(e, editable) {
		var par = $(this).parent();
		par.find(".optionlinks").hide();
		par.find(".badge").hide();
	});

	$("#chapterList .list-group-item .list-group-item-heading").on("hidden", function(e, reason) {
		var par = $(this).parent();
		par.find(".optionlinks").removeAttr("style");
		par.find(".badge").removeAttr("style");
	});

	$("#chapterList").delegate(".optionlinks a[href=\'#edit\']", "click", function(e) {
		e.preventDefault();
		$(this).parent().parent().find(".list-group-item-heading").editable("show", true);
		return false;
	});

	var delElement;
	function delFunc(delElem) {
		delElement = delElem;
		var id = $(delElem).attr("data-chapter-id");

		if (!Date.now) {
			Date.now = function() { return new Date().getTime(); };
		}
		var oxsysAPI = "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/delChapter/").'/?ts=" + Date.now();
		var myData = {"id":id};

		$(delElem).addClass("disabled").find(".optionlinks").hide().find(".badge").hide();
		$(delElem).find(".list-group-item-heading").editable("disable");

		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			if (data.error != "") {
				var jbox = new jBox(\'Modal\', {
					width: 350,
					height: 100,
					title: \'ข้อผิดพลาด\',
					overlay: true,
					content: data.msg,
				});
				jbox.open();
				$(delElement).removeClass("disabled").find(".optionlinks").removeAttr("style").find(".badge").removeAttr("style");
				$(delElement).find(".list-group-item-heading").editable("enable");
			}
			else
			{
				delElem.slideUp(400, function() { $(this).remove(); });
			}

		})
		.fail(function(jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log("Request Failed: "+err);

			var jbox = new jBox(\'Modal\', {
				width: 350,
				height: 100,
				title: \'ข้อผิดพลาด\',
				overlay: true,
				content: \'ไม่สามารถเพิ่มบทได้ กรุณาตรวจสอบความถูกต้อง\',
			});
			jbox.open();

			$(delElement).removeClass("disabled").find(".optionlinks").removeAttr("style").find(".badge").removeAttr("style");
			$(delElement).find(".list-group-item-heading").editable("enable");
		});
	};
	$("#chapterList").delegate(".optionlinks a[href=\'#remove\']", "click", function(e) {
		e.preventDefault();
		delFunc($(this).parent().parent());
		return false;
	});

';

		$this->questionManage = '
	function applyCKE() {
		//var qElem = $("#question");
		CKEDITOR.replace("question");
	};
	applyCKE();
';

		$this->scriptList = array(
			'chapterManage' => $this->chapterManage,
			'questionManage' => $this->questionManage,
		);
		define('useEditor', true);
	}

	private function getAddScripts()
	{
		return $this->scriptList;
	}

	function callbackjson()
	{
		// JSON Callback with modes & arguments.

		# Simulation loading...
		//sleep(1);

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
				$subject_id = trim($this->input->post('subject_id'));
				$chapterName = trim($this->input->post('chapterName'));
				if ($subject_id != "")
				{
					if ($chapterName != "")
					{
						$subject_data = $this->subjects->getSubjectById($subject_id);
						if (!empty($subject_data)) {
							$subject_id = $subject_data['subject_id'];
							$ret = $this->qwh->addChapter($subject_id, trim(urldecode($chapterName)));
							//$ret = 0; // Testing
							if ($ret['errno'] == 0)
							{
								echo json_encode(
									array(
										'msg' => trim(urldecode($chapterName)),
										'id' => $ret['id'],
										'return' => "Success",
										'error' => $ret['errno'],
								));
							}
							else
								echo json_encode($ret);
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

			case 'renChapter':
				$chapter_id = trim($this->input->post('pk'));
				$chapterName = trim($this->input->post('value'));
				if ($chapter_id != "")
				{
					if ($chapterName != "")
					{
						$ret = $this->qwh->renChapter($chapter_id, urldecode($chapterName));
						if ($ret == 0)
						{
							echo json_encode(
								array(
									'msg' => trim(urldecode($chapterName)),
									'return' => "Success",
									'error' => "")
								);
						}
						else
							echo json_encode(array('error' => $ret));
					}
					else
						echo json_encode(array('error' => "No Name"));
				}
				else
					echo json_encode(array('error' => "No Chapter_id"));
				break;

			case 'delChapter':
				$chapter_id = trim($this->input->post('id'));
				if ($chapter_id != "") {
					$ret = $this->qwh->delChapter($chapter_id);
					if ($ret['errno'] == 0 && $ret['result'] == "deleted") {
						echo json_encode(
							array(
								'return' => "Success",
								'error' => "",
						));
					}
					else echo json_encode($ret);
				}
				else
					echo json_encode(array('error' => "No Chapter_id"));

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