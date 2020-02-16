<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class newsletter_control extends CI_Controller {
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
        /* Get job detail based on slug */
        $field = array('title', 'post_name', 'board_name', 'eligibility', 'total_post', 'last_date', 'is_online', 'is_offline', 'qualification', 'age_criteria', 'payable_fee', 'detail_of_post', 'scale_of_pay', 'selection_mode', 'how_to_apply', 'important_link', 'created_date');
        $data['record'] = $this->general_model->select_single('job_master', $field, array('slug' => $slug), '', '=');
        $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
        $this->load->view('front/include/template', $data);
    }

    public function add_record()
    {
        $response = [];
        $email = $this->input->post('email');
        if(!empty($email))
        {
            /* Check email id exits or not */
            $check_email = $this->general_model->select('job_newsletter',array('id'),array('email_id' => $email),'','=');
            if(!empty($check_email))
            {
                $response['status'] = 0;
                $response['message'] = $this->lang->line('email_already_exits');
            }
            else
            {
                $cdata['email_id'] = $email;
                $last_id = $this->general_model->insert('job_newsletter',$cdata);
                if(!empty($last_id))
                {
                    /* Send email for subscription */
                    $activation_tmpl = $this->load->view('front/email_template/newsletter', $cdata,TRUE);

                    $sub = $this->config->item('sitename') . " : Thanks for Subscribing!";
                    $from = $this->config->item('admin_email');
                    $sendmail = $this->common_function_model->send_email($email, $sub, $activation_tmpl, $from);
                }
                $response['status'] = 1;
                $response['message'] = $this->lang->line('email_register');
            }
        }
        else
        {
            $response['status'] = 0;
            $response['message'] = $this->lang->line('email_already_exits');
        }
        echo json_encode($response);
    }
}
