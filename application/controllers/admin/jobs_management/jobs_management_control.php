<?php

/*
  @Description: qualification controller
  @Input:
  @Output:
  @Date: 21-10-2017

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class jobs_management_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->admin_session = $this->session->userdata('jow_admin_session');
        $this->message_session = $this->session->userdata('message_session');
        check_admin_login();
        $this->load->model('common_function_model','imageupload_model','general_model');
        $this->viewName = $this->router->uri->segments[2];
        $this->user_type = 'admin';
        $this->load->library('google_url_api');
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
            $this->session->unset_userdata('jobs_sortsearchpage_data');
        }
        $data['sortfield'] = 'id';
        $data['sortby'] = 'desc';
        $searchsort_session = $this->session->userdata('jobs_sortsearchpage_data');

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
        $config['base_url'] = site_url($this->user_type . '/' . "jobs_management/");
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
            $searchkeyword = @mysqli_real_escape_string(mysqli_init(),html_entity_decode(trim($searchtext)));
            $match = array('post_name' => $searchkeyword, 'board_name' => $searchkeyword, 'total_post' => $searchkeyword, 'qualification' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_master', '', $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', '', $match, '', 'like', '', '', '', '', '', '', '1', '');
        } else {
            $data['datalist'] = $this->general_model->select('job_master', '', '', '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', '', '', '', '', '', '', '', '', '', '', '1', '');
        }
        //pr($data['datalist']); exit;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['msg'] = $this->message_session['msg'];

        $jobs_sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);
        $this->session->set_userdata('jobs_sortsearchpage_data', $jobs_sortsearchpage_data);
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
        /* Get qualification data from qualification table */
        $fields = array('id,name');
        $data['qualification_type'] = $this->general_model->select('qualification_master', $fields);
        $data['job_type'] = $this->general_model->select('job_type_master', $fields);
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
        $this->load->library('upload');
        $uploadfilepath = $this->config->item('upload_file_path');
        $this->load->library('adf');
        $cdata = [];
        $qdata = [];
        $jdata = [];
        $last_date = $this->input->post('last_date');
        $qualification_type = $this->input->post('qualification_type');
        $job_type = $this->input->post('job_type');
        $label = $this->input->post('label');
        $important_link = $this->input->post('important_link');
        $upload_file = $_FILES;

        $cdata['title'] = $this->input->post('job_title');
        $cdata['post_name'] = $this->input->post('job_post');
        $cdata['slug'] = $this->input->post('job_slug');
        $cdata['board_name'] = $this->input->post('job_board');
        $cdata['eligibility'] = $this->input->post('job_eligibility');
        $cdata['total_post'] = $this->input->post('job_post_no');
        $cdata['last_date'] = !empty($last_date) ? date('Y-m-d', strtotime($last_date)) : '';
        $cdata['is_online'] = $this->input->post('is_online');
        $cdata['is_offline'] = $this->input->post('is_offline');
        $cdata['qualification'] = $this->input->post('job_of_education');
        $cdata['age_criteria'] = $this->input->post('job_age_criteria');
        $cdata['payable_fee'] = $this->input->post('job_payable_fee');
        $cdata['detail_of_post'] = $this->input->post('job_of_detail');
        $cdata['scale_of_pay'] = $this->input->post('job_scale_of_pay');
        $cdata['selection_mode'] = $this->input->post('job_selection_mode');
        $cdata['how_to_apply'] = $this->input->post('job_apply');
        //$cdata['important_link'] = $this->input->post('important_link');
        $cdata['created_by'] = $this->admin_session['id'];

        /* Get shortlink */
        $url = base_url().'job/'.$cdata['slug'];
        $result = $this->adf->shorten(array($url), 'adf.ly');
        if(!empty($result))
        {
            $result = json_decode($result);
            $shortenedUrl = $result->data[0];
            if(!empty($result->data[0]->short_url))
            {
                $cdata['short_url'] = $result->data[0]->short_url;
            }
        }

        /* Get shortlink from google */
        $short_url = $this->google_url_api->shorten($url);
        if(!empty($short_url) && $this->google_url_api->get_http_status() == 200)
        {
            $cdata['google_short_url'] = $short_url->id;
        }

        /* data insert */
        $last_id = $this->general_model->insert('job_master', $cdata);

        if (!empty($job_type)) {
            foreach ($job_type as $key => $type) {
                $jdata['job_id'] = $last_id;
                $jdata['job_type_id'] = $type;
                $jdata['created_by'] = $this->admin_session['id'];
                $this->general_model->insert('job_type_trans', $jdata);
            }
        }

        if (!empty($qualification_type)) {
            foreach ($qualification_type as $key => $type) {
                $qdata['job_id'] = $last_id;
                $qdata['job_qualification_id'] = $type;
                $qdata['created_by'] = $this->admin_session['id'];
                $this->general_model->insert('job_qualification_trans', $qdata);
            }
        }

        /*if (!empty($important_link)) {
            foreach ($important_link as $key => $type)
            {
                $idata = [];
                $idata['job_id']        = $last_id;
                $idata['label']         = !empty($label[$key]) ? $label[$key] : $this->lang->line('common_label_advertisement_detail');
                $idata['advertisement_link'] = $type;
                $idata['created_by']    = $this->admin_session['id'];
                $this->general_model->insert('job_advertisement_trans', $idata);
            }
        } */

        if (!empty($label)) {
            foreach ($label as $key => $label_name)
            {
                $idata = [];
                $idata['job_id']        = $last_id;
                $idata['label']         = !empty($label_name) ? $label_name : $this->lang->line('common_label_advertisement_detail');
                if(!empty($important_link[$key]))
                {
                    $idata['advertisement_link'] = $important_link[$key];
                }
                if(!empty($upload_file['upload_file']['name'][$key]))
                {
                    $config['upload_path']          = $uploadfilepath;
                    $config['allowed_types']        = '*';
                    $config['encrypt_name']         = TRUE;
                    $this->upload->initialize($config);

                    $_FILES['upload_file']['name']= $upload_file['upload_file']['name'][$key];
                    $_FILES['upload_file']['type']= $upload_file['upload_file']['type'][$key];
                    $_FILES['upload_file']['tmp_name']= $upload_file['upload_file']['tmp_name'][$key];
                    $_FILES['upload_file']['error']= $upload_file['upload_file']['error'][$key];
                    $_FILES['upload_file']['size']= $upload_file['upload_file']['size'][$key];

                    if (!$this->upload->do_upload('upload_file'))
                    {
                        $idata['uploaded_file'] = $this->upload->display_errors();
                    }
                    else
                    {
                        $data_uploaded_file = $this->upload->data();
                        $idata['uploaded_file'] = $data_uploaded_file['file_name'];
                    }
                }
                $idata['created_by']    = $this->admin_session['id'];
                $this->general_model->insert('job_advertisement_trans', $idata);
            }
        }

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

    public function edit_record()
    {
        $id = $this->uri->segment(4);
        $data['smenu_title'] = $this->lang->line('admin_left_menu15');
        $data['submodule'] = $this->lang->line('admin_left_ssclient');

        $fields = array('id,name');
        $data['qualification_type'] = $this->general_model->select('qualification_master', $fields);
        $data['job_type'] = $this->general_model->select('job_type_master', $fields);

        $result = $this->general_model->select('job_master', '', array('id' => $id), '', '=');

        $table = 'job_master as jm';
        $fields = array('jm.*, GROUP_CONCAT( DISTINCT  jtt.job_type_id) as type_id, GROUP_CONCAT( DISTINCT  jqt.job_qualification_id) as qualification_id');
        $join_tables = array('job_type_trans as jtt' => 'jtt.job_id = jm.id', 'job_qualification_trans as jqt' => 'jqt.job_id = jm.id');
        $join_type = 'LEFT';
        $condition = array('jm.id' => $id);
        $result = $this->general_model->getmultiple_tables_records($table, $fields, $join_tables, $join_type, '', $condition);
        //pr($this->db->last_query());
        //pr($result); exit;
        /* Get Important link from table */
        if(!empty($result))
        {
            $data['important_link'] = $this->general_model->select('job_advertisement_trans', array('id','label','advertisement_link','uploaded_file'), array('job_id' => $result[0]['id']), '', '=');
        }
        ///pr($data['important_link']); exit;
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

    public function update_data()
    {
        $this->load->library('adf');
        $cdata = [];
        $qdata = [];
        $jdata = [];

        $cdata['id'] = $this->input->post('id');
        $last_date = $this->input->post('last_date');
        $qualification_type = $this->input->post('qualification_type');
        $job_type = $this->input->post('job_type');
        $label = $this->input->post('label');
        $important_link = $this->input->post('important_link');

        $cdata['title'] = $this->input->post('job_title');
        $cdata['slug'] = $this->input->post('job_slug');
        $cdata['post_name'] = $this->input->post('job_post');
        $cdata['board_name'] = $this->input->post('job_board');
        $cdata['eligibility'] = $this->input->post('job_eligibility');
        $cdata['total_post'] = $this->input->post('job_post_no');
        $cdata['last_date'] = !empty($last_date) ? date("Y-m-d", strtotime($last_date)) : '';
        $cdata['is_online'] = $this->input->post('is_online');
        $cdata['is_offline'] = $this->input->post('is_offline');
        $cdata['qualification'] = $this->input->post('job_of_education');
        $cdata['age_criteria'] = $this->input->post('job_age_criteria');
        $cdata['payable_fee'] = $this->input->post('job_payable_fee');
        $cdata['detail_of_post'] = $this->input->post('job_of_detail');
        $cdata['scale_of_pay'] = $this->input->post('job_scale_of_pay');
        $cdata['selection_mode'] = $this->input->post('job_selection_mode');
        $cdata['how_to_apply'] = $this->input->post('job_apply');
        //$cdata['important_link'] = $this->input->post('important_link');
        $cdata['modified_by'] = $this->admin_session['id'];

        $url = base_url().'job/'.$cdata['slug'];
        $result = $this->adf->shorten(array($url), 'adf.ly');
        if(!empty($result))
        {
            $result = json_decode($result);
            $shortenedUrl = $result->data[0];
            if(!empty($result->data[0]->short_url))
            {
                $cdata['short_url'] = $result->data[0]->short_url;
            }
        }

        /* Get shortlink from google */
        $short_url = $this->google_url_api->shorten($url);
        if(!empty($short_url) && $this->google_url_api->get_http_status() == 200)
        {
            $cdata['google_short_url'] = $short_url->id;
        }

        /* Update data */
        $this->general_model->update('job_master', $cdata, array('id' => $cdata['id']));

        /* Delete type and qualification type */
        $this->general_model->delete('job_type_trans', array('job_id' => $cdata['id']));
        $this->general_model->delete('job_qualification_trans', array('job_id' => $cdata['id']));

        if (!empty($job_type)) {
            foreach ($job_type as $key => $type) {
                $jdata['job_id'] = $cdata['id'];
                $jdata['job_type_id'] = $type;
                $jdata['created_by'] = $this->admin_session['id'];
                $this->general_model->insert('job_type_trans', $jdata);
            }
        }

        if (!empty($qualification_type)) {
            foreach ($qualification_type as $key => $type) {
                $qdata['job_id'] = $cdata['id'];
                $qdata['job_qualification_id'] = $type;
                $qdata['created_by'] = $this->admin_session['id'];
                $this->general_model->insert('job_qualification_trans', $qdata);
            }
        }

        /* delete important link */
        $this->general_model->delete('job_advertisement_trans' , array('job_id' => $cdata['id']));

        if (!empty($important_link)) {
            foreach ($important_link as $key => $type)
            {
                $idata = [];
                $idata['job_id']        = $cdata['id'];
                $idata['label']         = !empty($label[$key]) ? $label[$key] : $this->lang->line('common_label_advertisement_detail');
                $idata['advertisement_link'] = $type;
                $idata['created_by']    = $this->admin_session['id'];
                $this->general_model->insert('job_advertisement_trans', $idata);
            }
        }

        $msg = $this->lang->line('common_edit_success_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);

        $searchsort_session = $this->session->userdata('jobs_sortsearchpage_data');
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
        $id = $this->uri->segment(4);
        $this->obj->delete_record($id);
        $msg = $this->lang->line('common_delete_success_msg');
        $newdata = array('msg' => $msg);
        $this->session->set_userdata('message_session', $newdata);
        redirect('admin/' . $this->viewName);
    }

    function checkslug() {
        pr($_POST);
        exit;
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
        $this->general_model->update('job_master', $cdata, array('id' => $cdata['id']));

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
        $this->general_model->update('job_master', $cdata, array('id' => $cdata['id']));

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
        if (!empty($id)) {
            $this->general_model->delete('job_master', array('id' => $id));
            $this->general_model->delete('job_type_trans', array('job_id' => $id));
            $this->general_model->delete('job_qualification_trans', array('job_id' => $id));
        }

        $array_data = $this->input->post('myarray');
        $delete_all_flag = 0;
        $cnt = 0;
        for ($i = 0; $i < count($array_data); $i++) {
            $this->general_model->delete('job_master', array('id' => $array_data[$i]));
            $this->general_model->delete('job_type_trans', array('job_id' => $array_data[$i]));
            $this->general_model->delete('job_qualification_trans', array('job_id' => $array_data[$i]));
            $delete_all_flag = 1;
            $cnt++;
        }
        //pagingation
        $searchsort_session = $this->session->userdata('jobs_sortsearchpage_data');
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
            $this->general_model->update('job_master', $cdata, array('id' => $array_data[$i]));
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
            $this->general_model->update('job_master', $cdata, array('id' => $array_data[$i]));
        }
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
        echo $pagingid = !empty($searchsort_session['uri_segment']) ? $searchsort_session['uri_segment'] : 0;
    }

    public function link_delete()
    {
        $id = $this->input->post('id');
        if(!empty($id))
        {
            $this->general_model->delete('job_advertisement_trans', array('id' => $id ));
        }
    }

}
