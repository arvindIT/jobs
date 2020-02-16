<?php

/*
  @Description: qualification controller
  @Input:
  @Output:
  @Date: 21-10-2017

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class jobtype_management_control extends CI_Controller {

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

    public function index() {
        $searchopt = '';
        $searchtext = '';
        $date1 = '';
        $date2 = '';
        $searchoption = '';
        $perpage = '';
        $searchtext = $this->input->post('searchtext');
        $sortfield = $this->input->post('sortfield');
        $sortby = $this->input->post('sortby');
        $searchopt = $this->input->post('searchopt');
        $perpage = $this->input->post('perpage');
        $allflag = $this->input->post('allflag');

        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $this->session->unset_userdata('job_type_sortsearchpage_data');
        }
        $data['sortfield'] = 'id';
        $data['sortby'] = 'desc';
        $searchsort_session = $this->session->userdata('job_type_sortsearchpage_data');

        if (!empty($sortfield) && !empty($sortby)) {
            $data['sortfield'] = $sortfield;
            $data['sortby'] = $sortby;
        } else {
            if (!empty($searchsort_session['sortfield'])) {
                if (!empty($searchsort_session['sortby'])) {
                    $data['sortfield'] = $searchsort_session['sortfield'];
                    $data['sortby'] = $searchsort_session['sortby'];
                    $sortfield = $searchsort_session['sortfield'];
                    $sortby = $searchsort_session['sortby'];
                }
            } else {
                $sortfield = 'id';
                $sortby = 'desc';
            }
        }
        if (!empty($searchtext)) {
            $data['searchtext'] = $searchtext;
        } else {
            if (empty($allflag)) {
                if (!empty($searchsort_session['searchtext'])) {
                    $data['searchtext'] = $searchsort_session['searchtext'];
                    $searchtext = $data['searchtext'];
                } else {
                    $data['searchtext'] = '';
                }
            } else {
                $data['searchtext'] = '';
            }
        }
        if (!empty($searchopt)) {
            $data['searchopt'] = $searchopt;
        }
        if (!empty($date1) && !empty($date2)) {
            $date1 = $this->input->post('date1');
            $date2 = $this->input->post('date2');
            $data['date1'] = $date1;
            $data['date2'] = $date2;
        }
        if (!empty($perpage) && $perpage != 'null') {
            $data['perpage'] = $perpage;
            $config['per_page'] = $perpage;
        } else {
            if (!empty($searchsort_session['perpage'])) {
                $data['perpage'] = trim($searchsort_session['perpage']);
                $config['per_page'] = trim($searchsort_session['perpage']);
            } else {
                $config['per_page'] = '10';
                $data['perpage'] = '10';
            }
        }
        $config['base_url'] = site_url($this->user_type . '/' . "jobtype_management/");
        $config['is_ajax_paging'] = TRUE; // default FALSE
        $config['paging_function'] = 'ajax_paging'; // Your jQuery paging
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        } else {
            $config['uri_segment'] = 3;
            $uri_segment = $this->uri->segment(3);
        }
        if (!empty($searchtext)) {
            $searchkeyword = @mysqli_real_escape_string(mysqli_init(), html_entity_decode(trim($searchtext)));
            $match = array('name' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_type_master', '', $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_type_master', '', $match, '', 'like', '', '', '', '', '', '', '1', '');
        } else {
            $data['datalist'] = $this->general_model->select('job_type_master', '', '', '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_type_master', '', '', '', '', '', '', '', '', '', '', '1', '');
        }
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['msg'] = $this->message_session['msg'];

        $job_type_sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);
        $this->session->set_userdata('job_type_sortsearchpage_data', $job_type_sortsearchpage_data);
        $data['uri_segment'] = $uri_segment;
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
        } else {
            $data['main_content'] = $this->user_type . '/' . $this->viewName . "/list";
            $this->load->view('admin/include/template', $data);
        }
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

    public function insert_data() {
        //pr($_POST);exit;
        $cdata['name'] = $this->input->post('name');
        $cdata['created_by'] = $this->admin_session['id'];

        $this->general_model->insert('job_type_master', $cdata);
        $msg = $this->lang->line('common_add_success_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);
        redirect('admin/' . $this->viewName);
    }

    /*
      @Description: Get Details of Edit User Profile
      @Author: Ruchi Shahu
      @Input: - Id of User member whose details want to change
      @Output: - Details of user which id is selected for update
      @Date: 20-11-2014
     */

    public function edit_record() {
        $id = $this->uri->segment(4);
        $data['smenu_title'] = $this->lang->line('admin_left_menu15');
        $data['submodule'] = $this->lang->line('admin_left_ssclient');

        $match = array('id' => $id);
        $result = $this->general_model->select('job_type_master', '', $match, '', '=');

        $data['editRecord'] = $result;
        $data['main_content'] = "admin/" . $this->viewName . "/add";
        $this->load->view("admin/include/template", $data);
    }

    /*
      @Description: Function for Update User Profile
      @Author: Ruchi Shahu
      @Input: - Update details of User
      @Output: - List with updated User details
      @Date: 28-06-2014
     */

    public function update_data() {
        $cdata['id'] = $this->input->post('id');
        $cdata['name'] = $this->input->post('name');

        /* Update data */
        $this->general_model->update('job_type_master', $cdata, array('id' => $cdata['id']));

        $msg = $this->lang->line('common_edit_success_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);

        $searchsort_session = $this->session->userdata('job_type_sortsearchpage_data');
        $pagingid = $searchsort_session['uri_segment'];
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
        echo "Asdadasd";
        exit;
        $id = $this->uri->segment(4);
        $this->obj->delete_record($id);
        $msg = $this->lang->line('common_delete_success_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);
        redirect('admin/' . $this->viewName);
    }

    /*
      @Description: Function for Unpublish User Profile By Admin
      @Author: Ruchi Shahu
      @Input: - Delete id which User record want to Unpublish
      @Output: - New User list after record is Unpublish.
      @Date: 28-06-2014
     */

    function unpublish_record() {
        $id = $this->uri->segment(4);

        $cdata['id'] = $id;
        $cdata['status'] = '0';

        /* Update data */
        $this->general_model->update('job_type_master', $cdata, array('id' => $cdata['id']));

        $msg = $this->lang->line('common_unpublish_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);

        //pagingation
        $delete_all_flag = 0;
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
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
      @Description: Function for publish User Profile By Admin
      @Author: Ruchi Shahu
      @Input: - Delete id which User record want to publish
      @Output: - New User list after record is publish.
      @Date: 28-06-2014
     */

    function publish_record() {
        $id = $this->uri->segment(4);

        $cdata['id'] = $id;
        $cdata['status'] = '1';

        /* Update data */
        $this->general_model->update('job_type_master', $cdata, array('id' => $cdata['id']));

        $msg = $this->lang->line('common_publish_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);

        //pagingation
        $delete_all_flag = 0;
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
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

    public function ajax_delete_all() {
        $admin = $this->session->userdata('jow_admin_session');

        $id = $this->input->post('single_remove_id');
        if (!empty($id) && $admin['id'] != $id) {
            $this->general_model->delete('job_type_master', array('id' => $id));
            unset($id);
        }

        $array_data = $this->input->post('myarray');
        $delete_all_flag = 0;
        $cnt = 0;
        for ($i = 0; $i < count($array_data); $i++) {
            $this->general_model->delete('job_type_master', array('id' => $array_data[$i]));
            $delete_all_flag = 1;
            $cnt++;
        }
        //pagingation
        $searchsort_session = $this->session->userdata('job_type_sortsearchpage_data');
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
      @Description: Function for publish all
      @Author: Niral Patel
      @Input: -
      @Output: -
      @Date: 21-07-15
     */
    public function ajax_publish_all() {
        $array_data = $this->input->post('myarray');
        $cdata['status'] = '1';
        for ($i = 0; $i < count($array_data); $i++) {
            $cdata['id'] = $array_data[$i];
            $this->general_model->update('job_type_master', $cdata, array('id' => $array_data[$i]));
        }
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
        echo $pagingid = !empty($searchsort_session['uri_segment']) ? $searchsort_session['uri_segment'] : 0;
    }

    /*
      @Description: Function for unpublish all
      @Author: Niral Patel
      @Input: -
      @Output: -
      @Date: 21-07-15
     */

    public function ajax_unpublish_all() {
        $array_data = $this->input->post('myarray');
        $cdata['status'] = '0';
        for ($i = 0; $i < count($array_data); $i++) {
            $cdata['id'] = $array_data[$i];
            $this->general_model->update('job_type_master', $cdata, array('id' => $array_data[$i]));
        }
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
        echo $pagingid = !empty($searchsort_session['uri_segment']) ? $searchsort_session['uri_segment'] : 0;
    }

}
