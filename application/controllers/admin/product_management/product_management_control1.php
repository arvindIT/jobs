<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class product_management_control extends CI_Controller {

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

    /*
      @Description: Function for Get All User List
      @Input: - Search value or null
      @Output: - all Qualification list
      @Date: 21-10-2017
     */

    public function index()
    {
        /* Get Setting detail form table */
        $view_data              = [];
        $fields                 = array('field,value');
        $data['editRecord']     = $this->general_model->select('product_master', $fields);
        if(!empty($data['editRecord']))
        {
            $data['editRecord'] = array_combine(array_map(function ($o) { return $o['field']; }, $data['editRecord']), $data['editRecord']);
        }
        $data['main_content'] = $this->user_type . '/' . $this->viewName . "/add";
        $this->load->view('admin/include/template', $data);
    }

    /*
      @Description: Function for Update User Profile
      @Author: Ruchi Shahu
      @Input: - Update details of User
      @Output: - List with updated User details
      @Date: 28-06-2014
     */

    public function update_data()
    {
        $field = $_POST;
        if(!empty($field))
        {
            foreach ($field as $field_key => $value)
            {
                $cdata = [];
                $cdata['value']         = !empty($value)?$value:'';
                /* Check field key ( slug ) exits */
                $exits_slug_id = $this->general_model->select_single('setting_master', array('id'), array('field' => $field_key), '','=');

                if(!empty($exits_slug_id))
                {
                    $cdata['modified_by']   = $this->admin_session['id'];
                    $this->general_model->update('setting_master', $cdata, array('id' => $exits_slug_id['id']));
                }
                else
                {
                    $cdata['field']         = $field_key;
                    $cdata['created_by']    = $this->admin_session['id'];
                    $this->general_model->insert('setting_master', $cdata);
                }
            }
        }
        redirect('admin/' . $this->viewName);
    }
}
