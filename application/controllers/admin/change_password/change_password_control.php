<?php 
/*
    @Description: tips controller
    @Author: Jayesh Rojasara
    @Date: 06-05-14
	
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class change_password_control extends CI_Controller
{	
    function __construct()
    {	
        parent::__construct();
        $this->admin_session = $this->session->userdata('jow_admin_session');
        $this->load->model('common_function_model');
		$this->load->model('admin_model');
		
		$this->obj = $this->admin_model;
		$this->viewName = $this->router->uri->segments[2];
    }
    /*
    @Description: Function for Get password
    @Author: Jayesh Rojasara
    @Date: 06-05-14
    */
    public function index()
    {	
		
		//$data['msg'] = ($this->uri->segment(3) == 'msg') ? $this->uri->segment(4) : '';
		$data['main_content'] = "admin/".$this->viewName."/change_password";
        $this->load->view('admin/include/template', $data);
    }
    /*
    @Description: Function for Update password
    @Author: Jayesh Rojasara
    @Input: - Update details of password
    @Output: - List with updated password details
    @Date: 07-05-14
    */
    public function admin_change_password()
    {
		$id = $this->admin_session['id'];
		$password = $this->common_function_model->encrypt_script($this->input->post('oldpassword'));
		
		$fields = array('id','email');
		$match = array('id'=>$id, 'password'=>$password);
		$result = $this->obj->get_user($fields,$match,'','=');
	
		if(!empty($result) && count($result)>0)
		{
			$cdata['id'] = $id;
			$cdata['password'] = $this->common_function_model->encrypt_script($this->input->post('password'));
			$update = $this->obj->update_user($cdata);
			$this->session->set_userdata('change_password_session',$this->lang->line('password_change_succ'));
			redirect('admin/'.$this->viewName);		
		}
		else
		{
			$this->session->set_userdata('change_password_session',$this->lang->line('invalid_old_password'));
			$this->session->userdata('change_password_session');
			//print_r($session_data);exit;
			redirect('admin/'.$this->viewName);
		}
       
    }
   
}