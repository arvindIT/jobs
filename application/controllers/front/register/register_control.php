<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class register_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_function_model');
        $this->load->model('general_model');
        $this->lang->load('front', 'english');
        $this->user_type = 'front';
        $this->viewName = 'register';
    }

    /*
      @Description: Function for Get All User List
      @Input: - Search value or null
      @Output: - all Qualification list
      @Date: 21-10-2017
     */

    public function index() {
        /* Get all education categories */
        $table = 'qualification_master as qm';
        $categories_field = array('qm.id', 'qm.name', 'count(jqt.id) as counter');
        $join_tables = array('job_qualification_trans as jqt' => 'jqt.job_qualification_id = qm.id');
        $join_type = "LEFT";
        $group_by = 'qm.id';
        $data['categories'] = $this->general_model->getmultiple_tables_records($table, $categories_field, $join_tables, $join_type, '', '', '', '', '', 'qm.priority', 'asc', $group_by);
        $data['total_categories'] = count($this->general_model->select('job_qualification_trans', array('id')));

        /* Get all job type */
        $job_type_table = 'job_type_master as jtm';
        $job_type_field = array('jtm.id', 'jtm.name', 'count(jtt.id) as counter');
        $join_tables = array('job_type_trans as jtt' => 'jtt.job_type_id = jtm.id');
        $join_type = "LEFT";
        $group_by = 'jtm.id';
        $data['job_type'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', '', '', '', '', $group_by);
        $data['total_job_type'] = count($this->general_model->select('job_type_trans', array('id')));

        /* Get latest 5 requirement */
        $data['latest_requirement'] = $this->general_model->select('job_master', array('id', 'title', 'total_post', 'slug'), '', '', '', '', '5', '', 'id', 'desc');
		$data['page_title'] = $this->lang->line('common_register_page_title');
        $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
        $this->load->view('front/include/template', $data);
    }

    public function add_record()
    {
        $email      = $this->input->post('email');
        $number     = $this->input->post('number');
        $zip_code   = $this->input->post('zip_code');
        $subscription   = $this->input->post('subscription');
        $this->form_validation->set_rules('firstname', 'First Name', 'required|trim');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|trim');
        $this->form_validation->set_rules('number', 'Whatsapp Number', 'required|trim|numeric|callback_check_number['. $number .']');
        if (!empty($email))
        {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_check_email['. $email .']');
        }
        if (!empty($zip_code))
        {
            $this->form_validation->set_rules('zip_code', 'Zip Code', 'trim|required|max_length[6]|numeric');
        }
        if ($this->form_validation->run() == FALSE)
        {
            $error_msg = validation_errors();
            $this->session->set_flashdata('error_message', $error_msg);
        }
        else
        {
            $cdata = [];
            $sdata = [];
            $cdata['first_name']    = !empty($this->input->post('firstname')) ? $this->input->post('firstname') : '';
            $cdata['last_name']     = !empty($this->input->post('lastname')) ? $this->input->post('lastname') : '';
            $cdata['email']         = !empty($this->input->post('email')) ? $this->input->post('email') : null;
            $cdata['contact_no']    = !empty($this->input->post('number')) ? $this->input->post('number') : '';
            $cdata['zip_code']      = !empty($this->input->post('zip_code')) ? $this->input->post('zip_code') : null;
            $this->general_model->insert('jow_users_register_master' , $cdata);

            /* check subscription checked or not */
            if(!empty($subscription) && !empty($email))
            {
                $sdata['email_id'] = $email;
                $this->general_model->insert('job_newsletter' , $sdata);

                /* Send email for subscription */
                $activation_tmpl = $this->load->view('front/email_template/newsletter', $cdata,TRUE);

                $sub = $this->config->item('sitename') . " : Thanks for Subscribing!";
                $from = $this->config->item('admin_email');
                $sendmail = $this->common_function_model->send_email($email, $sub, $activation_tmpl, $from);
            }
            $this->session->set_flashdata('success_message', 'Record added successfully.');
        }
        redirect('register');
    }

    public function check_email($email)
    {
        if (!empty($email))
        {
            /* Check email id exits */
            $chk_email = $this->general_model->select('jow_users_register_master',array('id'),array('email' => $email) , '', '=');
            if(!empty($chk_email))
            {
                $this->form_validation->set_message('check_email', 'Email already exits.');
                return false;
            }
            else
            {
                return true;
            }
        }
        else {
            $this->form_validation->set_message('check_email', 'Please enter email.');
            return false;
        }
    }

    public function check_number($numberl)
    {
        if (!empty($numberl))
        {
            /* Check email id exits */
            $chk_email = $this->general_model->select('jow_users_register_master',array('id'),array('contact_no' => $numberl) , '', '=');
            if(!empty($chk_email))
            {
                $this->form_validation->set_message('check_number', 'Whatsapp number already exits.');
                return false;
            }
            else
            {
                return true;
            }
        }
        else {
            $this->form_validation->set_message('check_email', 'Please enter whatsapp number.');
            return false;
        }
    }

}
