<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->admin_session = $this->session->userdata('jow_admin_session');
       	$this->message_session = $this->session->userdata('message_session');
        check_admin_login();
		$this->load->model('common_function_model');
		$this->load->model('general_model');
		$this->viewName = $this->router->uri->segments[2];
		$this->user_type = 'admin';
    }

    public function index()
    {
        $doc_session_array = $this->session->userdata('jow_admin_session');
        ($doc_session_array['active'] == true) ? $this->display_dashbord() : redirect('admin/login');
    }

    public function display_dashbord()
    {
		$data = [];
		
		/* Get total user count */
		$data['total_user'] = $this->general_model->select('jow_users_register_master','',array('status' => 1),'','=','','','','','','','1','');
		
		/* Get total male user count */
		$data['total_male_user'] = $this->general_model->select('jow_users_register_master','',array('status' => 1, 'gender' => 1),'','=','','','','','','','1','');
		
		/* Get total female user count */
		$data['total_female_user'] = $this->general_model->select('jow_users_register_master','',array('status' => 1, 'gender' => 2),'','=','','','','','','','1','');
		
        $data['msg'] = ($this->uri->segment(3) == 'msg') ? $this->uri->segment(4) : '';
        $data['main_content'] = "admin/home/dashboard";
        $this->load->view('admin/include/template', $data);
    }

}
