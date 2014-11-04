<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	/* Scripts */
	private $scriptList;

	private $subjectDropdownScript;
	private $datePicker;
	private $removePwd;
	private $listview;
	private $stdGroup;
	private $papers;
	private $sortable;

	private $role;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');

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

		$this->role = $this->session->userdata('role');

		// Prepare JavaScript !!
		$this->subjectDropdownScript = "

if ($('#subjectid').val() == '')
{
	$('#courseDesc').html('<h4>...กรุณาเลือกวิชา...<h4>');
}


$('#subjectid').change(function(){
	if($(this).val() == '')
	{
		$('#courseDesc').html('<h4>...กรุณาเลือกวิชา...<h4>');
	}
	else
	{
		$('#courseDesc').html('<h4><b><i class=\"fa fa-spinner fa-spin\"></i> กำลังโหลด...</b></h4>');
		var oxsysAPI = \"".$this->misc->getHref($this->role.'/courses/callbackjson/getSubjectDesc/')."/\" + $(this).val();
		$.getJSON( oxsysAPI, { format: \"json\" })
			.done(function(data) {
				$('#courseDesc').html(data.description);
			})
			.fail(function(jqxhr, textStatus, error) {
				var err = textStatus + \", \" + error;
				console.log(\"Request Failed: \"+err);
			});
	}
});";
		$this->datePicker = <<<HTML
	$('#modaladdpaper .input-daterange').datepicker({
		format: "dd/mm/yyyy",
		todayBtn: "linked",
		language: "th",
		orientation: "bottom left",
		autoclose: true,
		//todayHighlight: true
	});

	$('.timepicker').timepicker({
		showInputs: false,
		showMeridian: false,
		minuteStep: 5
	});
HTML;

		/*
			$('#timerange').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm'});

			var tdate = $('#startdate').val().split(\"/\");
			tdate = tdate[0]+'/'+tdate[1]+'/'+(parseInt(tdate[2],10)-543);
			$( '#dp1p' ).datepicker({
				onSelect: function(dateText, inst) {
					var tdate = dateText.split(\"/\");
					$('#startdate').val(tdate[0]+'/'+tdate[1]+'/'+(parseInt(tdate[2],10)+543) );
				},
				defaultDate: tdate,
				dayNames: ['อาทิตย์','จันทร์','อังคาร',
					'พุธ','พฤหัสบดี','ศุกร์','เสาร์'],
				dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
				monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม',
					'เมษายน','พฤษภาคม','มิถุนายน',
					'กรกฎาคม','สิงหาคม','กันยายน',
					'ตุลาคม','พฤศจิกายน','ธันวาคม'],
				monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.',
					'พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.',
					'พ.ย.','ธ.ค.'],
				changeMonth: true,
				changeYear: true,
				dateFormat: \"dd/mm/yy\"
			});";*/
		/*'//Datemask dd/mm/yyyy
//$("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
$("#startdate").datepicker({language:\'th-th\',format:\'dd/mm/yyyy\'});';*/

		$this->removePwd = "
		$('#removepwdlbl, #removepwdlbl>div>ins').click( function() {
			$('#password').val('');
			$('#password').attr('disabled', $('#removepass').is(':checked'));
		});";

		$this->listview = "


// filter select list options
});
jQuery.fn.filterByText = function(textbox, ListBox, selectSingleMatch) {
	return this.each(function() {
		var select = this;
		var options = [];
		$(select).find('option').each(function() {
			options.push({
				value: $(this).val(),
				text: $(this).text(),
				className: $(this).attr('class')
			});
		});
		$(select).data('options', options);

		$(textbox).bind('change keyup', function() {
			//var options = $(select).empty().scrollTop(0).data('options');
			var options = [];
			$(select).find('option').each(function() {
				if ($(this).attr('selected') === undefined)
				{
					options.push({
						value: $(this).val(),
						text: $(this).text(),
						className: $(this).attr('class')
					});
				}
			});

			var search = $(this).val().trim();
			var regex = new RegExp(search, \"gi\");

			$(ListBox).pickList('removeAll');
			var items = [];
			$.each(options, function(i) {
				var option = options[i];
				if (option.text.match(regex) !== null) {
					//$(select).append(
					//	$('<option>').text(option.text).val(option.value).addClass(option.className)
					//);
					items.push({
						value: option.value,
						label: option.text,
						selected: false
					});
				}
			});
			$(ListBox).pickList('showItems', items);
			if (selectSingleMatch === true && $(select).children().length === 1) {
				$(select).children().get(0).selected = true;
			}
		});
	});
};

$(function() {


	$('#teacherList').pickList({
		sourceListLabel: '<i class=\"fa fa-search\"></i><input id=\"teasearch\" class=\"searchbox\" type=\"text\" autocomplete=\"off\" />',
		targetListLabel: 'อาจารย์วิชา',

		mainClass: 'pickList col-sm-12',
		listContainerClass: 'panel panel-primary',
		listLabelClass: 'panel-heading',
		listClass: 'pickList_list list-group',
		listItemClass: 'pickList_listItem list-group-item',
		addAllClass: 'btn btn-default center-block',
		addClass: 'btn btn-default center-block',
		removeAllClass: 'btn btn-default center-block',
		removeClass: 'btn btn-default center-block',
		addLabel: '<i class=\"glyphicon glyphicon-chevron-right\"></i>',
		addAllLabel: '<i class=\"glyphicon glyphicon-chevron-right\"></i><i class=\"glyphicon glyphicon-chevron-right\"></i>',
		removeLabel: '<i class=\"glyphicon glyphicon-chevron-left\"></i>',
		removeAllLabel: '<i class=\"glyphicon glyphicon-chevron-left\"></i><i class=\"glyphicon glyphicon-chevron-left\"></i>'
	});

	$('#teacherList').filterByText($('#teasearch'), $('#teacherList') );

	$('#studentList').pickList({
		sourceListLabel: '<i class=\"fa fa-search\"></i><input id=\"stdsearch\" class=\"searchbox\" type=\"text\" autocomplete=\"off\" />',
		targetListLabel: 'นักเรียนในวิชา',

		mainClass: 'pickList col-sm-12',
		listContainerClass: 'panel panel-primary',
		listLabelClass: 'panel-heading',
		listClass: 'pickList_list list-group',
		listItemClass: 'pickList_listItem list-group-item',
		addAllClass: 'btn btn-default center-block',
		addClass: 'btn btn-default center-block',
		removeAllClass: 'btn btn-default center-block',
		removeClass: 'btn btn-default center-block',
		addLabel: '<i class=\"glyphicon glyphicon-chevron-right\"></i>',
		addAllLabel: '<i class=\"glyphicon glyphicon-chevron-right\"></i><i class=\"glyphicon glyphicon-chevron-right\"></i>',
		removeLabel: '<i class=\"glyphicon glyphicon-chevron-left\"></i>',
		removeAllLabel: '<i class=\"glyphicon glyphicon-chevron-left\"></i><i class=\"glyphicon glyphicon-chevron-left\"></i>'
	});

	$('#studentList').filterByText($('#stdsearch'), $('#studentList') );

	$('.searchbox').keydown(function(e) {
		if (e.which == 13)
		{
			e.preventDefault();
		}
	});

";

		$this->stdGroup = <<<HTML
	function btnAddState(btn, s, ori) {
		//var btn = $("#stdListSave");
		if (s == "load")
		{
			btn.removeClass("btn-primary").attr("disabled","disabled")
			.find("i").removeClass(ori).addClass("fa-spinner fa-spin");
		}
		else if(s == "normal")
		{
			btn.addClass("btn-primary").removeAttr("disabled")
			.find("i").removeClass("fa-spinner fa-spin").addClass(ori);
		}
	};

	$("#sectorListq").delegate("a[href^='#group/']", "click", function(e) {
		e.preventDefault();
		var group_id = $(this).attr("data-group-id");
		var stdgname = $(this).find(".list-group-item-heading").text();
		var stdgdesc = $(this).find(".item-group-item-text").text();

		// Load data
		var stdlist = $("#studentList");
		$(".questionLoading").show();
		stdlist.pickList("destroy");
		stdlist.css("visibility", 'hidden');
		stdlist.html('');

		$("#stdgroupname").text(stdgname);
		$("#askstdgname").text(stdgname);
		$("#stdgroupdesc").text(stdgdesc);

		$("#stugroup").attr("data-group-id", group_id).modal('show');

		var stdlist = $("#studentList");
		var oxsysAPI = "{$this->misc->getHref("teacher/courses/callbackjson/getStdListfromGroup/")}/?ts="+Date.now();

		var course_id = "course_id={$this->uri->segment(4)}";
		var myData = course_id + '&group_id=' + group_id;

		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			var stdlist = $("#studentList");
			if (data.error != "") {

				var jbox = new jBox('Modal', {
					width: 350,
					title: 'ข้อผิดพลาด',
					overlay: true,
					content: data.error,
				});
				jbox.open();
			}else{
				stdlist.html(data.html);
				stdlist.pickList({
					sourceListLabel: '<i class="fa fa-search"></i><input id="stdsearch" class="searchbox" type="text" autocomplete="off" />',
					targetListLabel: 'นักเรียนในวิชา',

					mainClass: 'pickList col-sm-12',
					listContainerClass: 'panel panel-primary',
					listLabelClass: 'panel-heading',
					listClass: 'pickList_list list-group',
					listItemClass: 'pickList_listItem list-group-item',
					addAllClass: 'btn btn-default center-block',
					addClass: 'btn btn-default center-block',
					removeAllClass: 'btn btn-default center-block',
					removeClass: 'btn btn-default center-block',
					addLabel: '<i class="glyphicon glyphicon-chevron-right"></i>',
					addAllLabel: '<i class="glyphicon glyphicon-chevron-right"></i><i class="glyphicon glyphicon-chevron-right"></i>',
					removeLabel: '<i class="glyphicon glyphicon-chevron-left"></i>',
					removeAllLabel: '<i class="glyphicon glyphicon-chevron-left"></i><i class="glyphicon glyphicon-chevron-left"></i>'
				});
				stdlist.filterByText($('#stdsearch'), $('#studentList') );
				stdlist.css("visibility", 'visible');
				$(".questionLoading").fadeOut();
			}
		})
		.fail(function(jqxhr, textStatus, error) {

			var err = textStatus + ", " + error;
			console.log("Request Failed: "+err);

			var jbox = new jBox('Modal', {
				width: 350,
				height: 100,
				title: 'ข้อผิดพลาด',
				overlay: true,
				content: error,
			});
			jbox.open();
		});
	});

	$("#stdListSave").click(function(e) {
		e.preventDefault();
		btnAddState($(this), "load", "fa-save");
		var oxsysAPI = "{$this->misc->getHref("teacher/courses/callbackjson/saveStdList/")}/?ts="+Date.now();

		var stdselected = decodeURIComponent($("#studentList").serialize());
		var course_id = "course_id={$this->uri->segment(4)}";
		var group_id = "group_id="+$(this).parent().parent().parent().parent().attr('data-group-id');
		var myData = course_id + '&' + group_id + '&' + stdselected;

		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			if (data.error != "") {

				var jbox = new jBox('Modal', {
					width: 350,
					title: 'ข้อผิดพลาด',
					overlay: true,
					content: data.error,
				});
				jbox.open();
			}else{
				$("#stugroup").modal('hide');
				var groupItem = $("#sectorListq").find("a[data-group-id='"+data.id+"'] .badge");
				if (data.members == '0')
					groupItem.text('');
				else
					groupItem.text(data.members);
			}
			btnAddState($("#stdListSave"), "normal", "fa-save");
		})
		.fail(function(jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log("Request Failed: "+err);

			var jbox = new jBox('Modal', {
				width: 350,
				height: 100,
				title: 'ข้อผิดพลาด',
				overlay: true,
				content: error,
			});
			jbox.open();
			btnAddState($("#stdListSave"), "normal", "fa-save");
		});

	});

	$("a[href='#addstdgroup']").click(function(e) {
		e.preventDefault();
		$("#stdgname").val('');
		$("#stdgdescription").val('');
		$("#addstugroup").modal('show');

	});

	$("#stdListAdd").click(function(e) {
		btnAddState($(this), "load", "fa-plus");
		var oxsysAPI = "{$this->misc->getHref("teacher/courses/callbackjson/addStdList/")}/?ts="+Date.now();

		var isError = 0;
		var stdgname = $("#stdgname");
		var stdgdesc = $("#stdgdescription");
		var modalAlert = $(this).parent().parent().find(".alert");


		if (stdgname.val() == "")
		{
			isError = 1;
			stdgname.parent().addClass("has-error");
		}
		else
			stdgname.parent().removeClass("has-error");
		if (isError == 0)
		{
			// Perform send.
			modalAlert.fadeOut();

			var course_id = "{$this->uri->segment(4)}";
			var myData = "name="+stdgname.val()+"&desc="+stdgdesc.val()+"&course_id="+course_id;

			$.ajax({
				type: "POST",
				url: oxsysAPI,
				data: myData,
				contentType: "application/x-www-form-urlencoded",
				dataType: "json"
			})
			.done(function(data) {
				if (data.error != "") {

					var jbox = new jBox('Modal', {
						width: 350,
						title: 'ข้อผิดพลาด',
						overlay: true,
						content: data.error,
					});
					jbox.open();
				}else{
					$("#addstugroup").modal('hide');
					var newgroupid = data.newid;
					var ghtml = "<a href=\"#group/"+newgroupid+"\" class=\"list-group-item\" data-group-id=\""+newgroupid+"\">"+
											"<span class=\"badge\"></span>"+
											"<h4 class=\"list-group-item-heading\">"+data.name+"</h4>"+
											"<div class=\"item-group-item-text\">"+data.desc+"</div>"+
											"</a>";
					$("#sectorListq").append(ghtml);
					$("#addstugroup").modal('hide');
				}
				btnAddState($("#stdListAdd"), "normal", "fa-plus");
			})
			.fail(function(jqxhr, textStatus, error) {
				var err = textStatus + ", " + error;
				console.log("Request Failed: "+err);

				var jbox = new jBox('Modal', {
					width: 350,
					height: 100,
					title: 'ข้อผิดพลาด',
					overlay: true,
					content: error,
				});
				jbox.open();
				btnAddState($("#stdListAdd"), "normal", "fa-plus");
			});
		}
		else
		{
			modalAlert.fadeIn();
			btnAddState($(this), "normal", "fa-plus");
		}

	});

	var delstdlist = function() {
		//e.preventDefault();
		btnAddState($("#stdListDel"), "load", "fa-trash-o");
		var oxsysAPI = "{$this->misc->getHref("teacher/courses/callbackjson/delStdList/")}/?ts="+Date.now();
		var course_id = "course_id={$this->uri->segment(4)}";
		var group_id = "group_id="+$("#stdListDel").parent().parent().parent().parent().attr('data-group-id');
		var myData = course_id + '&' + group_id;

		$.ajax({
			type: "POST",
			url: oxsysAPI,
			data: myData,
			contentType: "application/x-www-form-urlencoded",
			dataType: "json"
		})
		.done(function(data) {
			if (data.error != "") {

				var jbox = new jBox('Modal', {
					width: 350,
					title: 'ข้อผิดพลาด',
					overlay: true,
					content: data.error,
				});
				jbox.open();
			}else{
				$("#delstdgask").modal('hide');

				$("#sectorListq a[data-group-id='"+data.group_id+"'").remove();
			}
			btnAddState($("#stdListDel"), "normal", "fa-trash-o");
		})
		.fail(function(jqxhr, textStatus, error) {
			var err = textStatus + ", " + error;
			console.log("Request Failed: "+err);

			var jbox = new jBox('Modal', {
				width: 350,
				height: 100,
				title: 'ข้อผิดพลาด',
				overlay: true,
				content: error,
			});
			jbox.open();
			btnAddState($("#stdListDel"), "normal", "fa-times");
			$("#delstdgask").modal('hide');
		});
	}

	$("#stdListDel").click(function() {
		$("#delstdgask").modal('show');
	});

	$("#askstdgdelsure").click(function() {
		delstdlist();
	});

HTML;

		$this->papers = <<<HTML
	$('#addPaper').click(function(e) {
		$('#modaladdpaper').modal('show');
	});

	$('#modaladdpaper').on('hidden.bs.modal', function (e) {
		$("form[name='addpaper']")[0].reset();
		var myform = $(this);
		var txttitle = myform.find("input[name='title']");
		var txtdesc = myform.find("textarea[name='description']");
		var txtrules = myform.find("textarea[name='rules']");
		var txtstartdate = myform.find("input[name='startdate']");
		var txtenddate = myform.find("input[name='enddate']");
		var txtstarttime = myform.find("input[name='starttime']");
		var txtendtime = myform.find("input[name='endtime']");

		// clear class
		txttitle.parent().removeClass('has-error');
		txtdesc.parent().removeClass('has-error');
		txtrules.parent().removeClass('has-error');
		txtstartdate.parent().parent().removeClass('has-error');
		txtenddate.parent().parent().removeClass('has-error');
		txtstarttime.parent().parent().removeClass('has-error');
		txtendtime.parent().parent().removeClass('has-error');
		myform.find(".alert").hide();
	});

	$("#modaladdpaper form[name='addpaper']").submit(function(e) {

		// Form validation
		var hasError = false;
		var myform = $(this);
		var txttitle = myform.find("input[name='title']");
		var txtdesc = myform.find("textarea[name='description']");
		var txtrules = myform.find("textarea[name='rules']");
		var txtstartdate = myform.find("input[name='startdate']");
		var txtenddate = myform.find("input[name='enddate']");
		var txtstarttime = myform.find("input[name='starttime']");
		var txtendtime = myform.find("input[name='endtime']");

		// clear class
		txttitle.parent().removeClass('has-error');
		txtdesc.parent().removeClass('has-error');
		txtrules.parent().removeClass('has-error');
		txtstartdate.parent().parent().removeClass('has-error');
		txtenddate.parent().parent().removeClass('has-error');
		txtstarttime.parent().parent().removeClass('has-error');
		txtendtime.parent().parent().removeClass('has-error');

		// TRIM TXT
		myform.find("input, textarea").each(function() {
			$(this).val($.trim($(this).val()));
		});

		// Checking
		if (txttitle.val() == "") {
			hasError = true;
			txttitle.parent().addClass('has-error');
		}
		/*
		if (txtdesc.val() == "") {
			hasError = true;
			txtdesc.parent().addClass('has-error');
		}
		if (txtrules.val() == "") {
			hasError = true;
			txtrules.parent().addClass('has-error');
		}
		*/
		if (txtstartdate.val() == "") {
			hasError = true;
			txtstartdate.parent().parent().addClass('has-error');
		}
		if (txtenddate.val() == "") {
			hasError = true;
			txtenddate.parent().parent().addClass('has-error');
		}
		if (txtstarttime.val() == "") {
			hasError = true;
			txtstarttime.parent().parent().addClass('has-error');
		}
		if (txtendtime.val() == "") {
			hasError = true;
			txtendtime.parent().parent().addClass('has-error');
		}
		if (hasError) {
			myform.find(".alert").fadeIn();
			e.preventDefault();
		} else {
			myform.find(".alert").fadeOut();
			return;
		}

	});

	$('.paper-list').delegate('.list-group-item .content-toggle-click', 'click', function(e) {
		var contenttoggle = $(this).next('.content-toggle');
		var content = $(this).parent().find('.part-list');
		if ($.trim(content.html()) == "") return false;
		$(this).parent().toggleClass('active');
		contenttoggle.slideToggle(100);
	});

	$('.paper-list').delegate('.list-group-item .optionlinks a.add', 'click', function(e) {
		e.preventDefault();
		var paperid = $(this).parent().parent().attr('data-paperid');
		$('#modaladdpart').modal('show');

		// setting values
		var form = $("#modaladdpart form");
		form.find("input[type='text']").val('');
		form.find("input[type='checkbox']").iCheck('uncheck');
		form.find("textarea").val('');
		form.find("input[name='paper_id']").val(paperid);


	});

HTML;

		$this->sortable = <<<HTML
	
	$(".todo-list").sortable({
		placeholder: "sort-highlight",
		handle: ".handle",
		forcePlaceholderSize: true,
		zIndex: 999,
		stop: function(i) {
			placeholder: 'ui-state-highlight'
			$.ajax({
				type: "POST",
				url: "{$this->misc->getHref("teacher/courses/callbackjson/updatepartno/")}/?ts="+Date.now(),
				data: $(this).sortable("serialize")});
		}
	}).disableSelection();

	var resortOrder = function() {
		$("#selectedquestions .box").each(function(index,elem) {
			$(elem).find(".question-no").text(index+1);
			$(elem).find(".question-labelno").text("ข้อ");
		});
		$("#availablequestions .box").each(function(index,elem) {
			$(elem).find(".question-no").text('');
			$(elem).find(".question-labelno").text("");
		});
	};

	$(".questionSortable").sortable({
		placeholder: "sort-highlight",
		connectWith: ".questionSortable",
		handle: ".box-header, .nav-tabs",
		forcePlaceholderSize: true,
		zIndex: 999,
		stop: function(i) {
			resortOrder();
		}
	}).disableSelection();
	$(".questionSortable .box-header").css("cursor", "move");

	$("[data-widget='popqup']").click(function() {
		//Find the box parent        
		var box = $(this).parents(".box").first();
		var sortbox = box.parent().attr('id');
		if (sortbox == "selectedquestions")
		{
			box.appendTo("#availablequestions");
			resortOrder();
		}
		else if(sortbox == "availablequestions")
		{
			box.appendTo("#selectedquestions");
			resortOrder();
		}
	});

HTML;

		$this->scriptList = array(
			'subjectDropdownScript' => $this->subjectDropdownScript,
			'datePicker' => $this->datePicker,
			'removePwd' => $this->removePwd,
			'listview' => $this->listview,
			'stdGroup' => $this->stdGroup,
			'papers' => $this->papers,
			'sortable' => $this->sortable,
		);


	}

	private function getAddScripts()
	{
		return $this->scriptList;
	}

	public function index()
	{
		$this->load->view($this->role.'/t_header_view');
		$this->load->view($this->role.'/t_headerbar_view');
		$this->load->view($this->role.'/t_sidebar_view');

		// SET Default Per page
		$data['perpage'] = '10';
		if ($this->input->get('perpage')!='') $data['perpage'] = $this->input->get('perpage');

		$data['total'] = $this->courses->countCourseList($this->input->get('q'));
		$data['courseslist'] = $this->courses->getCourseList($this->input->get('q'),
			$data['perpage'],
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')));

		$this->misc->PaginationInit(
			$this->role.'/courses?perpage='.
			$data['perpage'].'&q='.$this->input->get('q'),
			$data['total'],$data['perpage']);

		$data['pagin'] = $this->pagination->create_links();


		$this->load->view($this->role.'/courses_view', $data);
		$this->load->view($this->role.'/t_footer_view');
	}

	public function view($courseId='')
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view($this->role.'/t_header_view');
		$this->load->view($this->role.'/t_headerbar_view');
		$this->load->view($this->role.'/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->edit($courseId);
		}
		else
		{
			if ($courseId == '')
			{
				redirect($this->role.'/courses');
			}
			else
			{
				$data['courseInfo'] = $this->courses->getCourseById($courseId);
				// Load Teachers
				$data['teacherListinCourse'] = $this->courses->getTeacherlist($courseId);
				$data['teacherListAvaliable'] = $this->courses->getTeacherlist($courseId, 'exclude');
				// Load Students
				$data['studentListinCourse'] = $this->courses->getStudentlist($courseId);
				$data['studentListAvaliable'] = $this->courses->getStudentlist($courseId, 'exclude');

				// Load Sectors
				$data['studentListGroups'] = $this->courses->getStudentGroups($courseId);

				// Load Exam Papers
				$data['examPapersList'] = $this->courses->getExamPapersList($courseId);

				$data['courseId'] = $courseId;

				// Set page desc
				$data['formlink'] = $this->role.'/courses/view/'.$courseId;
				$data['pagetitle'] = "ข้อมูลการเปิดสอบ";
				$data['pagesubtitle'] = $data['courseInfo']['code']." ".$data['courseInfo']['name'];

				$data['formlinkaddpaper'] = $this->role.'/courses/addpaper/'.$courseId;
				$data['formlinkaddpart'] = $this->role.'/courses/addpart/'.$courseId;
				$this->load->view('teacher/field_course_view', $data);
			}
		}

		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view($this->role.'/t_footer_view', $footdata);
	}

	public function add()
	{
		$this->load->view($this->role.'/t_header_view');
		$this->load->view($this->role.'/t_headerbar_view');
		$this->load->view($this->role.'/t_sidebar_view');

		$data['formlink'] = $this->role.'/courses/add';
		$data['pagetitle'] = "เปิดสอบวิชาใหม่";
		$data['pagesubtitle'] = "";
		$data['courseInfo'] = array(
			'subjectid' => set_value('subjectid'),
			'year' => set_value('year'),
			// 'startdate' => set_value('startdate'),
		);
		$data['teacherListinCourse'] = array();
		$data['teacherListAvaliable'] = $this->courses->getTeacherlist(null, 'all');

		if ($this->input->post('submit'))
		{
			$this->form_validation->set_rules('subjectid', 'รหัสวิชา', 'required');
			$this->form_validation->set_rules('year', 'ปีการศึกษา', 'required');
			// $this->form_validation->set_rules('startdate', 'วันที่เริ่ม', 'required');
			$this->form_validation->set_message('required', 'คุณต้องเลือก/กรอก %s');
			if ($this->form_validation->run())
			{
				# Form check completed
				$courseData['course_id'] = $courseId;
				$courseData['year'] = $this->input->post('year');
				// $courseData['startdate'] = $this->misc->reformatDate(
				// 	$this->misc->budDateToChrsDate($this->input->post('startdate'),"/","-"),"Y-m-d");
				$courseData['subject_id'] = $this->input->post('subjectid');
				$courseData['status'] = ($this->input->post('status')=="active"?"active":"inactive");
				$courseData['visible'] = ($this->input->post('visible')=="hidden"?"0":"1");


				if ($this->courses->addCourse($courseData))
				{
					# Add success
					$this->session->set_flashdata('msg_info',
						'เปิดวิชาเรียบร้อย');
					redirect($this->role.'/courses');
				} else {
					# Failed
					$this->session->set_flashdata('msg_error',
						'มีบางอย่างผิดพลาด ไม่สามารถวิชาได้');
					redirect($this->role.'/courses');
				}
			}
			else
			{
				$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
				$data['courseInfo'] = array(
					'subjectid' => set_value('subjectid'),
					'year' => set_value('year'),
					// 'startdate' => set_value('startdate'),
				);
				$this->load->view($this->role.'/field_course_view', $data);
			}
		}
		else
		{
			$this->load->view($this->role.'/field_course_view', $data);
		}
		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view($this->role.'/t_footer_view', $footdata);
	}

	public function edit($courseId)
	{
		$this->form_validation->set_rules('subjectid', 'รหัสวิชา', 'required');
		$this->form_validation->set_rules('year', 'ปีการศึกษา', 'required');
		// $this->form_validation->set_rules('startdate', 'วันที่เริ่ม', 'required');
		$this->form_validation->set_message('required', 'คุณต้องเลือก/กรอก %s');
		if ($this->form_validation->run())
		{
			# Form check completed
			$courseData['course_id'] = $courseId;
			$courseData['year'] = $this->input->post('year');
			// $courseData['startdate'] = $this->misc->reformatDate(
			// 	$this->misc->budDateToChrsDate($this->input->post('startdate'),"/","-"),"Y-m-d");
			$courseData['subject_id'] = $this->input->post('subjectid');
			$courseData['status'] = ($this->input->post('status')=="active"?"active":"inactive");
			$courseData['visible'] = ($this->input->post('visible')=="hidden"?"0":"1");

			// Update Teacher list
			$updateTeasRes = $this->courses->updateTeacherList($courseId,$this->input->post('teaselected'));
			if ($updateTeasRes != 0) {
				$this->session->set_flashdata('msg_error',
					'มีบางอย่างผิดพลาด ในการเพิ่มผู้สอน '.$updateTeasRes);
				redirect($this->role.'/courses');
			}

			// Update Student list
			// Moved to AJAX !

			# Remove password ??
			if ($this->input->post('removepass') == "1")
			{
				$courseData['pwd'] = null;
			}
			elseif ($this->input->post('password'))
				$courseData['pwd'] = $this->input->post('password');

			// die(var_dump($courseData));
			if ($this->courses->updateCourse($courseData, $courseId))
			{
				# แก้ไข success
				$this->session->set_flashdata('msg_info',
					'ปรับปรุงเรียบร้อย');
				redirect($this->role.'/courses');
			} else {
				# Failed
				$this->session->set_flashdata('msg_error',
					'มีบางอย่างผิดพลาด ไม่สามารถปรับปรุงได้');
				redirect($this->role.'/courses');
			}
		}
		else
		{
			$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
			$data['courseInfo'] = $this->courses->getCourseById($courseId);
			$data['formlink'] = $this->role.'/courses/view/'.$courseId;
			$data['pagetitle'] = "ข้อมูลการเปิดสอบ";
			$data['pagesubtitle'] = $data['courseInfo']['code']." ".$data['courseInfo']['name'];
			$this->load->view($this->role.'/field_course_view', $data);
		}
	}

	function addpaper($courseId='')
	{
		$paperData['title'] = $this->input->post('title');
		$paperData['description'] = $this->input->post('description');
		$paperData['rules'] = $this->input->post('rules');

		$paperData['starttime'] = $this->misc->reformatDate($this->input->post('startdate'),'Y-m-d', true, '/').
															' '.$this->input->post('starttime');
		$paperData['endtime'] = $this->misc->reformatDate($this->input->post('enddate'),'Y-m-d', true, '/').
															' '.$this->input->post('endtime');
		$paperData['course_id'] = $courseId;
		$addPapaer = $this->courses->addPaper($paperData);
		//echo $addPapaer['result'];
		$this->session->set_flashdata('msg_info',
					'เพิ่มชุดข้อสอบ '.$addPapaer['name'].' แล้ว');
				redirect($this->role.'/courses/view/'.$courseId);
	}

	function addpart($courseId='')
	{
		$partData['no'] = $this->input->post('no');
		$partData['title'] = $this->input->post('title');
		$partData['description'] = $this->input->post('description');
		$partData['israndom'] = ($this->input->post('random')=="true"?"1":"0");
		$partData['paper_id'] = $this->input->post('paper_id');
		$addPart = $this->courses->addPart($partData);

		$this->session->set_flashdata('msg_info',
					'เพิ่มตอน '.$partData['title'].' แล้ว');
				redirect($this->role.'/courses/view/'.$courseId);
	}

	function editpart($partId='')
	{
		$this->load->model('parteditor_model', 'parteditor');

		$this->load->view($this->role.'/t_header_view');
		$this->load->view($this->role.'/t_headerbar_view');
		$this->load->view($this->role.'/t_sidebar_view');

		$courseId = $this->courses->getCourseIdFromPartId($partId);
		$data['courseId'] = $courseId;
		$data['courseInfo'] = $this->courses->getCourseById($courseId);
		$data['partInfo'] = $this->courses->getPartInfoById($partId);
		$data['pagetitle'] = "ตัวแก้ไขชุดข้อสอบ";
		$data['pagesubtitle'] = $data['partInfo']['title'];

		$data['formlink'] = $this->role.'/courses/editpart/'.$courseId;


		$data['questionData'] = $this->parteditor->getQuestionDetailList($partId);
		$data['questionDataWh'] = $this->parteditor->getQuestionList(4);

		$this->load->view($this->role.'/field_parteditor_view', $data);
		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view($this->role.'/t_footer_view', $footdata);
	}

	function callbackjson()
	{
		// JSON Callback with modes & arguments.

		# Simulation loading...
		//sleep(1);

		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		$arg_list = func_get_args();
		switch ($arg_list[0]) {
			case 'getSubjectDesc':
				if (isset($arg_list[1]))
					echo json_encode($this->courses->getSubjectDesc($arg_list[1]));
				else
					echo json_encode(array('error' => "No Subject_id"));
				break;

			case 'getStdListfromGroup':
				$studentListinCourse = $this->courses->getStudentlist($this->input->post('course_id'), 'incourse', $this->input->post('group_id'));
				$studentListAvaliable = $this->courses->getStudentlist($this->input->post('course_id'), 'exclude', $this->input->post('group_id'));
				$html = "";

				foreach ($studentListAvaliable as $item) {
					$html .= '<option value="'.$item['stu_id'].'">'.$item['name'].' '.$item['lname'].
					'</option>';
				}
				foreach ($studentListinCourse as $item) {
					$html .= '<option value="'.$item['stu_id'].'" selected="selected">'.$item['name'].' '.$item['lname'].
					'</option>';
				}

				echo json_encode(array('html' => $html,
					'error' => ''));
				break;

			case 'getStdList':
				$cdata = $this->courses->buildPapersOptions($this->input->post('course_id'));
				$html = '';
				foreach ($cdata as $key => $value) {
					$html .= "<option value='$key'>$value</option>";
				}
				echo json_encode(array('html' => $html, 'error' => ''));
				break;

			case 'addStdList':
				$addStdList = $this->courses->addStudentGroup($this->input->post('course_id'),
					$this->input->post('name'), $this->input->post('desc'));
				if ($addStdList['error'] != 0)
				{
					$addStdList['error'] = '';
					echo json_encode($addStdList);
				}
				else
				{
					echo json_encode($addStdList);
				}
				break;

			case 'saveStdList':
				// Update Student list
				$updateStdsRes = $this->courses->updateStudentList($this->input->post('group_id'),
					$this->input->post('course_id'),
					$this->input->post('stdselected'));
				if ($updateStdsRes != 0) {
					echo json_encode(array('error' => 'Error with '.$updateStdsRes));
				}
				else
					echo json_encode(array('result' => 'completed',
						'error' => '',
						'members' => $this->courses->countStudentInGroup($this->input->post('group_id'),
							$this->input->post('course_id')),
						'id' => $this->input->post('group_id')));

				break;

			case 'delStdList':
				$updateStdsRes = $this->courses->updateStudentList($this->input->post('group_id'),
					$this->input->post('course_id'),
					$this->input->post('stdselected'));
				if ($updateStdsRes != 0) {
					echo json_encode(array('error' => 'Error delStdList.updateStdsRes with '.$updateStdsRes));
				}
				else
				{
					$deleteStdList = $this->courses->deleteStudentGroup($this->input->post('group_id'));
					if ($deleteStdList != 0) {
						echo json_encode(array('error' => 'Error delStdList.deleteStdList with '.$updateStdsRes));
					}
					else
					{
						echo json_encode(array('result' => 'completed',
																	'group_id' => $this->input->post('group_id'),
																	'error' => ''));
					}
				}

				break;
			case 'updatepartno':
				if (is_array($this->input->post('part')))
				{
					$this->courses->updatePartOrder($this->input->post('part'));
					echo json_encode(array('error' => '', 'result'=>'success'));
				}
				else
				{
					echo json_encode(array('error' => 'No Array'));
				}
				
				
				break;

			default:
				echo json_encode(array('error' => "No Arguments"));
				break;
		}
	}

}

/* End of file courses.php */
/* Location: ./application/controllers/teacher/courses.php */