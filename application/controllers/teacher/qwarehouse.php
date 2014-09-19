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
	$(\'a[href="\'+location.hash+\'"]\').tab(\'show\');

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
	function clearInput() {
		$("#newQuestion input[type=text]").val("");
		$("#newQuestion select#qtype").selectpicker("val", "choice");
		$("#newQuestion select#qstatus").selectpicker("val", "active");
		$("#newQuestion input[type=radio]").iCheck("uncheck");
		CKEDITOR.instances.question.setData("");
		CKEDITOR.instances.question.editable();
	};

	$(".chapterListGroup").scrollToFixed({
		marginTop: $(".chapterListGroup").outerHeight()+50,
	});

	$("a[href=#questions]").click(function(e){
		var oxsysAPI = "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/getChapterList/").'/?ts="+Date.now();
		var myData = {"subject_id":"'.$this->uri->segment(4).'"};
		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			$("#chapterListq").html(data.html);
		})
	});

	$("#newQuestion .box-body, #newQuestion .box-footer").hide();

	$("#newQuestion .nav-tabs").click(function(e){
		$("#newQuestion .box-body, #newQuestion .box-footer").slideDown();
	});

	$("#closeNewQuestion").click(function(e) {
		clearInput();
		$("#newQuestion .box-body, #newQuestion .box-footer").slideUp();
	});

	function applyCKE() {
		//var qElem = $("#question");
		CKEDITOR.replace("question", {
			customConfig: "config_q.js",
			extraPlugins: "richcombo,panelbutton,font,justify,colorbutton,uicolor,imageresize",
			"filebrowserImageUploadUrl": "'.base_url().'vendor/js/plugins/ckeditor/plugins/imgupload.php"
		});
		CKEDITOR.instances.question.editable();
	};
	applyCKE();

	for (instance in CKEDITOR.instances) {
		var editor = CKEDITOR.instances[instance];
		if ( editor ) {
			editor.on("focus", function (event) {
				$(".cke_top, .cke_bottom").slideDown(100);
			});
			editor.on("blur", function (event) {
				$(".cke_top, .cke_bottom").slideUp(100);
			});
			editor.on("instanceReady", function (event) {
				$(".cke_top, .cke_bottom").hide();
				$(".cke_contents").css("height","126px");
			});
		}
	}

	$(".question-type:not(#choice)").hide();
	$("select#qtype").change(function() {
		$(".question-type").slideUp();
		$("input[type=radio]").iCheck("uncheck")
		switch($(this).val()) {
			case "choice":
				$("#choice").slideDown();
				break;
			case "numeric":
				$("#numeric").slideDown();
				break;
			case "boolean":
				$("#boolean").slideDown();
				break;
		}
	});

	function btnAddState(s) {
		var btn = $("#addQuestion");
		if (s == "load")
		{
			btn.removeClass("btn-primary").attr("disabled","disabled")
			.find("i").removeClass("fa-plus").addClass("fa-spinner fa-spin");
		}
		else if(s == "normal")
		{
			btn.addClass("btn-primary").removeAttr("disabled")
			.find("i").removeClass("fa-spinner fa-spin").addClass("fa-plus");
		}
	};

	$("#addQuestion").click(function(e) {
		btnAddState("load");
		if (!Date.now) {
			Date.now = function() { return new Date().getTime(); };
		}
		var oxsysAPI = "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/addQuestion/").'/?ts="+Date.now();
		var chapter_id = $("#chapterListq").find(".active").attr("data-chapter-id");
		if (chapter_id == undefined)
		{
			var jbox = new jBox(\'Modal\', {
				width: 350,
				height: 100,
				title: \'ข้อผิดพลาด\',
				overlay: true,
				content: "ต้องเลือก Chapter ก่อน"
			});
			jbox.open();
			btnAddState("normal");
			return false;
		}

		var questionData = encodeURIComponent($.trim(CKEDITOR.instances.question.getData()));
		var qtype = encodeURIComponent($.trim($("#qtype").val()));
		var myData = "chapter_id=" + chapter_id + "&qtype=" + qtype + "&question=" + questionData + '.
								'"&chapter_name=" + encodeURIComponent($("#chapterListq").find(".active").text()) + '.
								'"&status=" + encodeURIComponent($("#qstatus").val());
		switch (qtype) {
			case "choice":
				myData += "&correct=" + encodeURIComponent($.trim($("input[name=correct]:checked").val()));
				myData += "&choice1="+encodeURIComponent($.trim($("#choice1").val()))+"&choice2="+encodeURIComponent($.trim($("#choice2").val()))+"&choice3="+encodeURIComponent($.trim($("#choice3").val()))+'.
										'"&choice4="+encodeURIComponent($.trim($("#choice4").val()))+"&choice5="+encodeURIComponent($.trim($("#choice5").val()))+"&choice6="+encodeURIComponent($.trim($("#choice6").val()));

				break;
			case "numeric":
				myData += "&correct=" + encodeURIComponent($.trim($("#correct-numeric").val()));
				break;
			case "boolean":
				myData += "&correct=" + encodeURIComponent($.trim($("input[name=correct]:checked").val()));
				break;
		}

		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			console.log("sent " + myData + " to " + oxsysAPI);
			console.log("received : " + data.return);

			if (data.error != "") {

				var jbox = new jBox(\'Modal\', {
					width: 350,
					//height: 100,
					title: \'ข้อผิดพลาด\',
					overlay: true,
					content: data.error,
				});
				jbox.open();
			}
			else
			{
				console.log("sent");
				clearInput();
				$(".question-notfound").remove();
				$("#newQuestion .box-body, #newQuestion .box-footer").slideUp();
				var respHtml = $(data.html);
				$("#questionList").prepend(respHtml);
				respHtml.hide().slideDown();
				$(".jtooltip").jBox("Tooltip", {theme: "TooltipDark"});
			}
			btnAddState("normal");

		})
		.fail(function(jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log("Request Failed: "+err);

			var jbox = new jBox(\'Modal\', {
				width: 350,
				height: 100,
				title: \'ข้อผิดพลาด\',
				overlay: true,
				content: error,
			});
			jbox.open();
			btnAddState("normal");
		});
	});

	// Select Chapter for Question
	$("#chapterListq").delegate(".list-group-item", "click", function(e) {
		e.preventDefault();
		$(this).siblings().removeClass("active");
		$(this).addClass("active");

		$(".questionLoading").slideDown();
		$("#questionList").slideUp();
		var chapter_id = $(this).attr("data-chapter-id");
		var oxsysAPI = "'.$this->misc->getHref("teacher/qwarehouse/callbackjson/getQuestionList/").'/?ts="+Date.now();
		var myData = "chapter_id="+chapter_id;
		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			setTimeout(function() {
				console.log("sent " + myData + " to " + oxsysAPI);

				var respHtml = $(data.html);
				$("#questionListTable").html(respHtml).slideDown();
				$(".questionLoading").slideUp();
				$(".jtooltip").jBox("Tooltip", {theme: "TooltipDark"});
			}, 500, data);
		})
		.fail(function(jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log("Request Failed: "+err);

			var jbox = new jBox(\'Modal\', {
				width: 350,
				height: 100,
				title: \'ข้อผิดพลาด\',
				overlay: true,
				content: error,
			});
			jbox.open();
			$(".questionLoading").slideUp();
		});
	});

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

			case 'getChapterList':
				$subject_data = $this->subjects->getSubjectById($this->input->post('subject_id'));
				$subject_id = $subject_data['subject_id'];
				$chapterList = $this->qwh->getChapterList($subject_id);
				$html = "";
				if (!empty($chapterList))
				{
					foreach ($chapterList as $item) {
						$html .= "<a href=\"#\" class=\"list-group-item\" data-chapter-id=\"$item[chapter_id]\">
						<span class=\"badge\"></span>
						<h4 class=\"list-group-item-heading\">$item[name]</h4>
						<div class=\"item-group-item-text\">$item[description]</div>
						</a>";
					}
				}

				echo json_encode(array(
					'html' => $html
				));

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

			// Questions
			case 'addQuestion':
				$chapter_id = trim($this->input->post('chapter_id'));
				$question_type = trim($this->input->post('qtype'));
				$answer = trim($this->input->post('correct'));
				$choices[0] = trim($this->input->post('choice1'));
				$choices[1] = trim($this->input->post('choice2'));
				$choices[2] = trim($this->input->post('choice3'));
				$choices[3] = trim($this->input->post('choice4'));
				$choices[4] = trim($this->input->post('choice5'));
				$choices[5] = trim($this->input->post('choice6'));

				// HTMLPurifier (Question)
				require_once 'application/libraries/htmlpurifier/HTMLPurifier.auto.php';
				$purifier = new HTMLPurifier();
				$question = $purifier->purify($this->input->post('question'));


				// Self Validating Input Data
				$msgerr = "ไม่สามารถเพิ่มได้ เนื่องจากข้อผิดพลาดดังต่อไปนี้<br><ul>";
				$errObj = array();

				if ($chapter_id == "" || !is_numeric($chapter_id))
				{
					$msgerr .= "<li>ไม่พบข้อมูล Chapter ID หรือไม่ถูกต้อง</li>";
				}
				if ($question_type == "" || ( ! in_array(
																					$question_type,
																					array('choice','numeric','boolean','matching')
																				)
																		)
					)
				{
					$msgerr .= "<li>ไม่พบข้อมูล Question type หรือไม่ถูกต้อง</li>";
					$errObj['qtype'] = 1;
				}
				if (trim(strip_tags($question)) == "")
				{
					$msgerr .= "<li>ต้องมีโจทย์คำถามสำหรับผู้ทำข้อสอบ</li>";
					$errObj['question'] = 1;
				}
				if ($answer == "")
				{
					$msgerr .= "<li>ต้องมี คำตอบที่ถูกต้อง</li>";
					$errObj['correct'] = 1;
				}

				switch ($question_type) {
					case 'choice':
						if (count(array_filter($choices)) < 2)
						{
							$msgerr .= "<li>ปรนัย : ต้องมีตัวเลือกอย่างน้อย 2 ข้อ</li>";
							$errObj['choices'] = 1;
						}
						if ($answer != "" || is_numeric($answer))
						{
							if ($choices[intval($answer) - 1] == "" || !isset($choices[intval($answer) - 1]))
							{
								$msgerr .= "<li>ปรนัย : ตัวเลือกที่ถูกต้อง ไม่ได้ใส่คำตอบ !</li>";
								$errObj['choices'] = 1;
								$errObj['choice'.$answer] = 1;
							}
						}
						else
						{
							$msgerr .= "<li>ปรนัย : ต้องเลือกคำตอบที่ถูกต้อง</li>";
							$errObj['choices'] = 1;
						}
						break;
					case 'numeric':
						// is_numeric() ????
						// $answer == ""
						if (!is_numeric($answer))
						{
							$msgerr .= "<li>เติมตัวเลข : ต้องระบุคำตอบที่ถูกต้องด้วยตัวเลข</li>";
							$errObj['correct'] = 1;
						}
						break;
					case 'boolean':
						if ( !in_array(strtolower($answer), array('t','f')) )
						{
							$msgerr .= "<li>ถูก / ผิด : เลือกคำตอบที่ถูกต้องเป็น ถูก หรือ ผิด</li>";
							$errObj['correct'] = 1;
						}
						break;

					default:
						$msgerr .= "<li>เงื่อนไข Question type ไม่ถูกต้อง</li>";
						break;
				}

				$msgerr .= "</ul>";

				if ($msgerr != "ไม่สามารถเพิ่มได้ เนื่องจากข้อผิดพลาดดังต่อไปนี้<br><ul></ul>")
				{
					echo json_encode(array(
						'error' => $msgerr,
						'objects' => $errObj
					));
					die();
				}
				// END Self Validating Data

				$qstatus = "";
				switch (strtolower($this->input->post('status'))) {
					case 'active':
					case 'inactive':
					case 'draft':
						$qstatus = strtolower($this->input->post('status'));
						break;

					default:
						$qstatus = "active";
						break;
				}

				$questionData = array(
					'question' => $question,
					'type' => $question_type,
					'status' => $qstatus,
					'chapter_id' => $chapter_id,
					'created_by_id' => $this->session->userdata('id')
				);
				$questionDataDetail = array();
				switch ($question_type) {
					case 'choice':
						$questionDataDetail = array(
							'choice1' => $choices[0],
							'choice2' => $choices[1],
							'choice3' => $choices[2],
							'choice4' => $choices[3],
							'choice5' => $choices[4],
							'choice6' => $choices[5],
							'answer' => $answer,
							'question_id' => ""
						);
						break;

					case 'numeric':
						$questionDataDetail = array(
							'answer' => $answer,
							'question_id' => ""
						);
						break;

					case 'boolean':
						$questionDataDetail = array(
							'answer' => $answer,
							'question_id' => ""
						);
						break;

					// No Implement yet
					case 'matching':
						throw new Exception("Case No implement yet", 1);
						break;

					default:
						throw new Exception("No question type", 1);

						break;
				}
				$insert_trans = $this->qwh->addQuestion($chapter_id, $questionData, $questionDataDetail);
				if ($insert_trans['errno'] == 0)
				{

					$data = array_merge($questionData, $questionDataDetail);
					$data['question_id'] = $insert_trans['id'];
					$data['chapter_name'] = $this->input->post('chapter_name');
					$data['created_time'] = date('Y-m-d H:i:s');
					$data['created_by'] = $this->session->userdata('fullname');
					switch ($question_type) {
						case 'choice':
							$data['answer_choice'] = $data['answer'];
							break;

						case 'numeric':
							$data['answer_numeric'] = $data['answer'];
							break;

						case 'boolean':
							$data['answer_boolean'] = $data['answer'];
							break;

						// No Implement yet
						case 'matching':
							throw new Exception("Case No implement yet", 1);
							break;

						default:
							throw new Exception("No question type", 1);
							break;
					}
					// var_dump($data);
					// die();
					$html = $this->load->view('teacher/question_item_view', $data, true);
					echo json_encode(array(
						'id' => $insert_trans['id'],
						'html' => $html,
						'error' => "",
						'errno' => ""
					));
				}
				else
				{
					// Error transaction !
					echo json_encode(array(
						'id' => '',
						'error' => "Cant insert",
						'errno' => $insert_trans['errno']
					));
				}

				break;

			case 'getQuestionList':
				$chapter_id = $this->input->post('chapter_id');
				$question_id = $this->input->post('question_id');
				$questionList = $this->qwh->QuestionList('',$chapter_id);
				if (!empty($questionList))
				{
					$html = "";
					foreach ($questionList as $row) {
						$html .= $this->load->view('teacher/question_item_table_view', $row, true);
					}
					echo json_encode(array(
						'html' => $html,
						'error' => "",
						'errno' => ""
					));
				}
				else
				{
					echo json_encode(array(
						'html' => $this->load->view('teacher/question_notfound_view', null, true),
						'error' => "ไม่มีข้อมูล",
						'errno' => "1"
					));
				}
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

	public function viewq($subjectId)
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view('teacher/t_header_view');
		$this->load->view('teacher/t_headerbar_view');
		$this->load->view('teacher/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			//$this->edit($subjectId);
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

					$this->load->view('teacher/field_qwarehouse_q_view', $data);
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