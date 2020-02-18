<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class register_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->admin_session = $this->session->userdata('jow_admin_session');
        $this->message_session = $this->session->userdata('message_session');
        check_admin_login();
        $this->load->model('general_model');
        $this->load->model('imageupload_model');
        $this->viewName = $this->router->uri->segments[2];
        $this->user_type = 'admin';
    }

    /*
      @Description: Function for Get All User List
      @Author: Ruchi Shahu
      @Input: - Search value or null
      @Output: - all User list
      @Date: 28-06-2014
     */

    public function index()
    {
        $data['main_content'] = "admin/" . $this->viewName . "/add";
        $this->load->view("admin/include/template", $data);
    }

    /*
      @Description: Function Add New User details
      @Author: Ruchi Shahu
      @Input: -
      @Output: - Load Form for add User details
      @Date: 28-06-2014
     */

    public function add_record() {
        $fields = array('id,name');
        $data['main_content'] = "admin/" . $this->viewName . "/add";
        $this->load->view('admin/include/template', $data);
    }

    /*
      @Description: Function for Insert New User data
      @Author: Ruchi Shahu
      @Input: - Details of new User which is inserted into DB
      @Output: - List of User with new inserted records
      @Date: 28-06-2014
     */

    public function insert_data()
    {
        $this->form_validation->set_rules('user_first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('user_last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required|min_length[10]|max_length[10]');
        $this->form_validation->set_rules('user_gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|valid_email');
        
        if ($this->form_validation->run() == FALSE)
        {
                $this->load->view('myform');
        }
        else
        {
            $old_user_pic                   = $this->input->post('old_user_pic');
            $bgImgPath                      = $this->config->item('user_pic_img_big');
            $smallImgPath                   = $this->config->item('user_pic_img_small');
            if(!empty($_FILES['user_pic']['name']))
            {
                $uploadFile     = 'user_pic';
                $thumb          = "thumb";
                $hiddenImage    = !empty($old_user_pic)?$old_user_pic:'';
                $cdata['pic']   = $this->imageupload_model->uploadBigImage($uploadFile,$bgImgPath,$smallImgPath,$thumb,$hiddenImage);
            }
			$birth_date = $this->input->post('user_birthday');
            $cdata['first_name']            = $this->input->post('user_first_name');
            $cdata['last_name']             = $this->input->post('user_last_name');
            $cdata['gender']                = $this->input->post('user_gender');
            $cdata['email']                 = $this->input->post('user_email');
            $cdata['contact_no']            = $this->input->post('user_mobile');
            $cdata['highest_qualification'] = $this->input->post('usre_highest_qualification');
            $cdata['location']              = $this->input->post('user_location');
            $cdata['dob'] 					= !empty($birth_date) ? date('Y-m-d', strtotime($birth_date)) : '';
            $cdata['created_date']          = date('Y-m-d H:i:s');
            $cdata['created_by']            = $this->admin_session['id'];
            
            $this->general_model->insert('jow_users_register_master', $cdata);
            $msg = $this->lang->line('common_add_success_msg');
            $newdata = array('msg' => $msg);
            $this->session->set_userdata('message_session', $newdata);
            redirect('admin/user_management', 'refresh');
        }
    }

    /*
      @Description: Get Details of Edit User Profile
      @Author: Ruchi Shahu
      @Input: - Id of User member whose details want to change
      @Output: - Details of user which id is selected for update
      @Date: 20-11-2014
     */

     public function edit_record()
    {
        $id                     = $this->uri->segment(4);
        $data['smenu_title']    = $this->lang->line('admin_left_menu15');
        $data['submodule']      = $this->lang->line('admin_left_ssclient');
        $match                  = array('id' => $id);        
        $result                 = $this->general_model->select('jow_users_register_master','',$match,'','=');        
        $data['editRecord']     = $result;
        $data['main_content']   = "admin/register/add";
        $this->load->view("admin/include/template", $data);
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
		$user_birthday					= trim($this->input->post('user_birthday'));
        $cdata['id']                    = trim($this->input->post('user_id'));
        $cdata['first_name']            = trim($this->input->post('user_first_name'));
        $cdata['last_name']             = trim($this->input->post('user_last_name'));
        $cdata['gender']                = trim($this->input->post('user_gender'));
        $cdata['email']                 = trim($this->input->post('user_email'));
        $cdata['contact_no']            = trim($this->input->post('user_mobile'));
        $cdata['highest_qualification'] = trim($this->input->post('usre_highest_qualification'));
        $cdata['location']              = trim($this->input->post('user_location'));
        $cdata['dob']                   = !empty($user_birthday) ? date('Y-m-d', strtotime($user_birthday)) : '' ;
        $cdata['modified_date']         = date('Y-m-d H:i:s');
        $cdata['modified_by']           = $this->admin_session['id'];
        
        $this->general_model->update('jow_users_register_master', $cdata, array('id' => $cdata['id']));

        $msg        = $this->lang->line('common_edit_success_msg');
        $newdata    = array('msg' => $msg);
        
        $this->session->set_userdata('message_session', $newdata);
        
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
        $pagingid           = $searchsort_session['uri_segment'];
        
        redirect('admin/' . $this->viewName . '/' . $pagingid);
    }

    /*
      @Description: Function for Delete User Profile By Admin
      @Author: Ruchi Shahu
      @Input: - Delete id which User record want to delete
      @Output: - New User list after record is deleted.
      @Date: 28-06-2014
     */

    function delete_record() {
        $id = $this->uri->segment(4);
        $this->obj->delete_record($id);
        $msg = $this->lang->line('common_delete_success_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);
        redirect('admin/' . $this->viewName);
    }

    public function my_profile()
	{
        $id = $this->uri->segment(4);
        $data['smenu_title'] = $this->lang->line('admin_left_menu15');
        $data['submodule'] = $this->lang->line('admin_left_ssclient');
        $fields = array('id,name');
        $match = array('id' => $id);
        $result = $this->obj->select_records('', $match, '', '=');
        $data['editRecord'] = $result;
        $data['main_content'] = "admin/" . $this->viewName . "/my_profile";
        $this->load->view("admin/include/template", $data);
    }

    /*
      @Description: Function for Unpublish User Profile By Admin
      @Author: Ruchi Shahu
      @Input: - Delete id which User record want to Unpublish
      @Output: - New User list after record is Unpublish.
      @Date: 28-06-2014
     */

    function unpublish_record()
	{
        $id = $this->uri->segment(4);
        $cdata['id'] = $id;
        $cdata['status'] = '0';
        $this->obj->update_record($cdata);
        $msg = $this->lang->line('common_unpublish_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);
        $user_id = $id;
        $pagingid = $this->obj->getuserpagingid($user_id);
        redirect('admin/' . $this->viewName . '/' . $pagingid);
    }

    /*
      @Description: Function for publish User Profile By Admin
      @Author: Ruchi Shahu
      @Input: - Delete id which User record want to publish
      @Output: - New User list after record is publish.
      @Date: 28-06-2014
     */

    function publish_record()
	{
        $id = $this->uri->segment(4);
        $cdata['id'] = $id;
        $cdata['status'] = '1';
        $this->obj->update_record($cdata);
        $msg = $this->lang->line('common_publish_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);

        $user_id = $id;
        $pagingid = $this->obj->getuserpagingid($user_id);
        redirect('admin/' . $this->viewName . '/' . $pagingid);
    }

    public function ajax_delete_all() {
        $admin = $this->session->userdata('admin_session');

        $id = $this->input->post('single_remove_id');
        if (!empty($id) && $admin['id'] != $id) {
            $this->obj->delete_record($id);
            unset($id);
        }

        $array_data = $this->input->post('myarray');
        $delete_all_flag = 0;
        $cnt = 0;
        for ($i = 0; $i < count($array_data); $i++) {
            $this->obj->delete_record($array_data[$i]);
            $delete_all_flag = 1;
            $cnt++;
        }
        //pagingation
        $searchsort_session = $this->session->userdata('admin_sortsearchpage_data');
        if (!empty($searchsort_session['uri_segment']))
            $pagingid = $searchsort_session['uri_segment'];
        else
            $pagingid = 0;
        $perpage = !empty($searchsort_session['perpage']) ? $searchsort_session['perpage'] : '10';
        $total_rows = $searchsort_session['total_rows'];
        if ($delete_all_flag == 1) {
            $total_rows -= $cnt;
            if ($pagingid * $perpage > $total_rows) {
                if ($total_rows % $perpage == 0) {
                    $pagingid -= $perpage;
                }
            }
        } else {
            if ($total_rows % $perpage == 1)
                $pagingid -= $perpage;
        }

        if ($pagingid < 0)
            $pagingid = 0;
        echo $pagingid;
    }

    /*
      @Description: Function for checking customer already exist or not
      @Author: Parth Khatri
      @Input: - Email and id
      @Output: - send flag for existing or not
      @Date: 27-01-2015
     */

    public function check_user() {

        $id = $this->input->post('id');
        $email = $this->input->post('email');

        if ($id == 0) {
            $regex = '/^([a-zA-Z\d_\.\-\+%])+\@(([a-zA-Z\d\-])+\.)+([a-zA-Z\d]{2,4})+$/';
            if (preg_match($regex, $email)) {
                $email1 = strtolower($email);
                $user_type = '1';
                $match = array('email' => $email1);
                $exist_email = $this->obj->select_records('', $match, '', '=', '');

                if (!empty($exist_email)) {
                    echo '1';
                } else {
                    echo '0';
                }
            } else {
                echo '2';
            }
        } else {
            $match = array('id' => $id);
            $exist_id = $this->obj->select_records('', $match, '', '=', '');
            $email_old = $exist_id[0]['email'];
            $regex = '/^([a-zA-Z\d_\.\-\+%])+\@(([a-zA-Z\d\-])+\.)+([a-zA-Z\d]{2,4})+$/';
            if (preg_match($regex, $email)) {
                if ($email == $email_old) {
                    echo "0";
                } else {
                    $match = array('email' => $email);
                    $email_exist = $this->obj->select_records('', $match, '', '=', '');
                    if (!empty($email_exist)) {
                        echo '1';
                    } else {
                        echo '0';
                    }
                }
            } else {
                echo '2';
            }
        }
    }

}
