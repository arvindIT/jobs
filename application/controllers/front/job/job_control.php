<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class job_control extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('common_function_model');
        $this->load->model('general_model');
        $this->lang->load('front','english');
        $this->user_type = 'front';
        $this->viewName = 'job';
    }
    /*
      @Description: Function for Get All User List
      @Input: - Search value or null
      @Output: - all Qualification list
      @Date: 21-10-2017
     */
    public function index() {
        /* Get job slug */
        $slug = $this->uri->segment(2);
        if (empty($slug)) {
            /* redirect to home */
            redirect();
        }
        /* Get latest 5 requirement */
        $data['latest_requirement'] = $this->general_model->select('job_master',array('id','title','total_post','slug'),'','','','','5','','id','desc');
        /* Get job detail based on slug */
        $field = array('id','title', 'post_name', 'board_name', 'eligibility', 'total_post', 'last_date', 'is_online', 'is_offline', 'qualification', 'age_criteria', 'payable_fee', 'detail_of_post', 'scale_of_pay', 'selection_mode', 'how_to_apply', 'short_url', 'important_link', 'created_date');
        $data['record'] = $this->general_model->select_single('job_master', $field, array('slug' => $slug), '', '=');

        /* Get important link of record */
        if(!empty($data['record']))
        {
            $data['record']['important_link'] = $this->general_model->select('job_advertisement_trans', array('label','advertisement_link'), array('job_id' => $data['record']['id']), '', '=');
        }
        //pr($data['record']); exit;
        $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
	$data['page_title'] = $this->lang->line('common_job_page_title');
        $this->load->view('front/include/template', $data);
    }
    public function display_dashbord() {
        $data = [];
        /* Get total user count */
        $data['total_user'] = $this->general_model->select('jow_users_register_master', '', array('status' => 1), '', '=', '', '', '', '', '', '', '1', '');
        /* Get total male user count */
        $data['total_male_user'] = $this->general_model->select('jow_users_register_master', '', array('status' => 1, 'gender' => 1), '', '=', '', '', '', '', '', '', '1', '');
        /* Get total female user count */
        $data['total_female_user'] = $this->general_model->select('jow_users_register_master', '', array('status' => 1, 'gender' => 2), '', '=', '', '', '', '', '', '', '1', '');
        $data['msg'] = ($this->uri->segment(3) == 'msg') ? $this->uri->segment(4) : '';
        $data['main_content'] = "admin/home/dashboard";
        $this->load->view('admin/include/template', $data);
    }
}
