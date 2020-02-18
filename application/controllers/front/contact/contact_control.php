<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class contact_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_function_model');
        $this->load->model('general_model');
        $this->lang->load('front', 'english');
        $this->user_type = 'front';
        $this->viewName = 'contact';
    }

    /*
      @Description: Function for Get All User List
      @Input: - Search value or null
      @Output: - all Qualification list
      @Date: 21-10-2017
     */

    public function index() {
        $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
        $data['page_title'] = $this->lang->line('common_contact_page_title');
        $this->load->view('front/include/template', $data);
    }

    public function send_message()
    {
        $cdata = [];
        $result = [];
        $post = $_POST;;
        if (empty($post)) {
            redirect();
        } else {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|is_valid');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');
            if ($this->form_validation->run() == FALSE)
            {
                $this->load->view('myform');
            } else
            {
                $cdata['name']      = $this->input->post('name');
                $cdata['email']     = $this->input->post('email');
                $cdata['message']   = $this->input->post('message');

                /* Send email */
                $activation_tmpl = $this->load->view('front/email_template/contact', $cdata,TRUE);

                $email  = $this->config->item('admin_email');
                $sub    = $this->config->item('sitename') . " : ".$cdata['name']." want to contact you.";
                $from   = !empty($cdata['email']) ? $cdata['email'] : '';
                $sendmail = $this->common_function_model->send_email($email, $sub, $activation_tmpl, $from);

                $result['status'] = 1;
                $result['message'] = $this->lang->line('common_success_email_message');
            }
            echo json_encode($result);
        }
    }

}
