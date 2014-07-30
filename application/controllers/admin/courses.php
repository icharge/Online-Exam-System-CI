<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Courses extends CI_Controller {

	private $subjectDropdownScript;
	private $datePicker;
	private $removePwd;
	private $listview;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users_model', 'Users');
		$this->load->model('misc_model', 'misc');
		$this->load->model('courses_model', 'courses');

		// Permissions List for this Class
		$perm = array('admin');
		// Check
		if ($this->Users->_checkLogin())
		{
			if ( ! $this->Users->_checkRole($perm)) redirect('main');
		} else {
			redirect('auth/login');
		}

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
		var oxsysAPI = \"".$this->misc->getHref('admin/courses/callbackjson/getSubjectDesc/')."/\" + $(this).val();
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
		$this->datePicker = "var tdate = $('#startdate').val().split(\"/\");
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
			});";
		/*'//Datemask dd/mm/yyyy
//$("#startdate").inputmask("dd/mm/yyyy", {"placeholder": "dd/mm/yyyy"});
$("#startdate").datepicker({language:\'th-th\',format:\'dd/mm/yyyy\'});';*/

		$this->removePwd = "
		$('#removepwdlbl, #removepwdlbl>div>ins').click( function() {
			$('#password').val('');
			$('#password').attr('disabled', $('#removepass').is(':checked'));
		});";

		$this->listview = "
$('.add').click(function(){
	//$('.all').prop(\"checked\",false);
	$('.all').iCheck('uncheck');
	var items = $(\"#list1 input:checked:not('.all')\").parent().parent();
	var n = items.length;
	if (n > 0) {
		items.each(function(idx,item){
			var choice = $(item);
			choice.prop(\"checked\",false);
			choice.parent().appendTo(\"#list2\");
		});
	}
	else {
		alert(\"Choose an item from list 1\");
	}
});

$('.remove').click(function(){
	//$('.all').prop(\"checked\",false);
	$('.all').iCheck('uncheck');
	var items = $(\"#list2 input:checked:not('.all')\").parent().parent();
	items.each(function(idx,item){
		var choice = $(item);
		choice.prop(\"checked\",false);
		choice.parent().appendTo(\"#list1\");
	});
});

/* toggle all checkboxes in group */
$('.all').click(function(e){
	e.preventDefault();

	var \$this = $(this);
	// iCheck
	if(\$this.is(\":checked\")) {
		\$this.parents('.list-group').find(\"[type=checkbox]\").iCheck('uncheck');
		//.prop(\"checked\",true);
	}
	else {
		\$this.parents('.list-group').find(\"[type=checkbox]\").iCheck('check');
		//.prop(\"checked\",false);
			\$this.prop(\"checked\",false);
	}
});

$('[type=checkbox]').click(function(e){
	e.stopPropagation();
});

/* toggle checkbox when list group item is clicked */
$('.list-group a').click(function(e){
	e.preventDefault();
	e.stopPropagation();

	var \$this = $(this).find(\"[type=checkbox]\");

	// For iCheck
	$(\$this).iCheck('toggle');
	
	/*if(\$this.is(\":checked\")) {
		\$this.prop(\"checked\",false);
	}
	else {
		\$this.prop(\"checked\",true);
	}*/

	if (\$this.hasClass(\"all\")) {
		\$this.trigger('click');
	}
});

// iCheck
$('.all > div > ins').click(function(e){
	var \$this = $(this).siblings('[type=checkbox]');
	if (\$this.hasClass(\"all\")) {
		\$this.trigger('click');
	}
});


";

	}

	private function getAddScripts()
	{
		return array(
			'subjectDropdownScript' => $this->subjectDropdownScript,
			'datePicker' => $this->datePicker,
			'removePwd' => $this->removePwd,
			'listview' => $this->listview,
		);
	}

	public function index()
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		// SET Default Per page
		$data['perpage'] = '10';
		if ($this->input->get('perpage')!='') $data['perpage'] = $this->input->get('perpage');

		$data['total'] = $this->courses->countCourseList($this->input->get('q'));
		$data['courseslist'] = $this->courses->getCourseList($this->input->get('q'),
			$data['perpage'], 
			$this->misc->PageOffset($data['perpage'],$this->input->get('p')));

		$this->misc->PaginationInit(
			'admin/courses?perpage='.
			$data['perpage'].'&q='.$this->input->get('q'),
			$data['total'],$data['perpage']);

		$data['pagin'] = $this->pagination->create_links();

		
		$this->load->view('admin/courses_view', $data);
		$this->load->view('admin/t_footer_view');
	}

	public function view($courseId='')
	{
		$this->session->set_flashdata('noAnim', true);
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		if ($this->input->post('submit'))
		{
			$this->edit($courseId);
		}
		else
		{
			if ($courseId == '')
			{
				redirect('admin/courses');
			}
			else
			{
				$data['courseInfo'] = $this->courses->getCourseById($courseId);
				$data['teacherListAvaliable'] = $this->courses->getTeacherlist($courseId);
				$data['formlink'] = 'admin/courses/view/'.$courseId;
				$data['pagetitle'] = "ข้อมูลการเปิดสอบ";
				$data['pagesubtitle'] = $data['courseInfo']['code']." ".$data['courseInfo']['name'];
				$this->load->view('admin/field_course_view', $data);
			}
		}

		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view('admin/t_footer_view', $footdata);
	}

	public function add()
	{
		$this->load->view('admin/t_header_view');
		$this->load->view('admin/t_headerbar_view');
		$this->load->view('admin/t_sidebar_view');

		$data['formlink'] = 'admin/courses/add';
		$data['pagetitle'] = "เปิดสอบวิชาใหม่";
		$data['pagesubtitle'] = "";
		$data['courseInfo'] = array(
			'subjectid' => set_value('subjectid'),
			'year' => set_value('year'),
			'startdate' => set_value('startdate'),
		);

		if ($this->input->post('submit'))
		{
			$this->form_validation->set_rules('subjectid', 'รหัสวิชา', 'required');
			$this->form_validation->set_rules('year', 'ปีการศึกษา', 'required');
			$this->form_validation->set_rules('startdate', 'วันที่เริ่ม', 'required');
			$this->form_validation->set_message('required', 'คุณต้องเลือก/กรอก %s');
			if ($this->form_validation->run())
			{
				# Form check completed
				$courseData['course_id'] = $courseId;
				$courseData['year'] = $this->input->post('year');
				$courseData['startdate'] = $this->misc->reformatDate(
					$this->misc->budDateToChrsDate($this->input->post('startdate'),"/","-"),"Y-m-d");
				$courseData['subject_id'] = $this->input->post('subjectid');
				$courseData['status'] = ($this->input->post('status')=="active"?"active":"inactive");
				
				if ($this->courses->addCourse($courseData))
				{
					# Add success
					$this->session->set_flashdata('msg_info', 
						'เปิดวิชาเรียบร้อย');
					redirect('admin/courses');
				} else {
					# Failed
					$this->session->set_flashdata('msg_error', 
						'มีบางอย่างผิดพลาด ไม่สามารถวิชาได้');
					redirect('admin/courses');
				}
			}
			else
			{
				$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
				$data['courseInfo'] = array(
					'subjectid' => set_value('subjectid'),
					'year' => set_value('year'),
					'startdate' => set_value('startdate'),
				);
				$this->load->view('admin/field_course_view', $data);
			}
		}
		else
		{
			$this->load->view('admin/field_course_view', $data);
		}
		// Send additional script to footer
		$footdata['additionScript'] = $this->getAddScripts();
		$this->load->view('admin/t_footer_view', $footdata);
	}

	public function edit($courseId)
	{
		$this->form_validation->set_rules('subjectid', 'รหัสวิชา', 'required');
		$this->form_validation->set_rules('year', 'ปีการศึกษา', 'required');
		$this->form_validation->set_rules('startdate', 'วันที่เริ่ม', 'required');
		$this->form_validation->set_message('required', 'คุณต้องเลือก/กรอก %s');
		if ($this->form_validation->run())
		{
			# Form check completed
			$courseData['course_id'] = $courseId;
			$courseData['year'] = $this->input->post('year');
			$courseData['startdate'] = $this->misc->reformatDate(
				$this->misc->budDateToChrsDate($this->input->post('startdate'),"/","-"),"Y-m-d");
			$courseData['subject_id'] = $this->input->post('subjectid');
			$courseData['status'] = ($this->input->post('status')=="active"?"active":"inactive");

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
				redirect('admin/courses');
			} else {
				# Failed
				$this->session->set_flashdata('msg_error', 
					'มีบางอย่างผิดพลาด ไม่สามารถปรับปรุงได้');
				redirect('admin/courses');
			}
		}
		else
		{
			$data['msg_error'] = 'กรุณากรอกข้อมูลให้ครบ';
			$data['courseInfo'] = $this->courses->getCourseById($courseId);
			$data['formlink'] = 'admin/courses/view/'.$courseId;
			$data['pagetitle'] = "ข้อมูลการเปิดสอบ";
			$data['pagesubtitle'] = $data['courseInfo']['code']." ".$data['courseInfo']['name'];
			$this->load->view('admin/field_course_view', $data);
		}
	}

	function callbackjson()
	{
		// JSON Callback with modes & arguments.

		# Simulation loading...
		sleep(1);

		$this->output->set_header('Content-Type: application/json; charset=utf-8');
		$arg_list = func_get_args();
		switch ($arg_list[0]) {
			case 'getSubjectDesc':
				if (isset($arg_list[1]))
					echo json_encode($this->courses->getSubjectDesc($arg_list[1]));
				else
					echo json_encode(array('error' => "No Subject_id"));
				break;
			
			default:
				echo json_encode(array('error' => "No Arguments"));
				break;
		}
	}
	
}

/* End of file courses.php */
/* Location: ./application/controllers/courses.php */