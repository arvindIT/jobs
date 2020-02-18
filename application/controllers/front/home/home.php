<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_function_model');
        $this->load->model('general_model');
        $this->lang->load('front', 'english');
        $this->user_type = 'front';
        $this->viewName = 'home';
    }

    /*
      @Description: Function for Get All User List
      @Input: - Search value or null
      @Output: - all Qualification list
      @Date: 21-10-2017
     */

    public function index() {
        //echo "asdasd"; exit;
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
            $this->session->unset_userdata('job_sortsearchpage_data');
        }
        $data['sortfield'] = 'id';
        $data['sortby'] = 'desc';
        $sortfield = 'id';
        $sortby = 'desc';
        $config['per_page'] = '10';
        $data['perpage'] = '10';

        $searchsort_session = $this->session->userdata('job_sortsearchpage_data');
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

        $config['base_url'] = base_url($this->user_type);
        $config['is_ajax_paging'] = TRUE; // default FALSE
        $config['paging_function'] = 'ajax_paging'; // Your jQuery paging
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        } else {
            $config['uri_segment'] = 2;
            $uri_segment = $this->uri->segment(2);
        }
        $field = array('title', 'slug', 'post_name', 'eligibility', 'total_post', 'last_date', 'is_online', 'is_offline','created_date');
        if (!empty($searchtext)) {
            $searchkeyword = @mysqli_real_escape_string(mysqli_init(),html_entity_decode(trim($searchtext)));
            $match = array('post_name' => $searchkeyword, 'board_name' => $searchkeyword, 'total_post' => $searchkeyword, 'qualification' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_master', $field, $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), $match, '', 'like', '', '', '', '', '', '', '1', '');
        } else {
            $data['datalist'] = $this->general_model->select('job_master', $field, '', '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), '', '', '', '', '', '', '', '', '', '1', '');
        }

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
        $data['latest_requirement'] = $this->general_model->select('job_master',array('id','title','total_post','slug'),'','','','','5','','id','desc');

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $job_sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);
        $this->session->set_userdata('job_sortsearchpage_data', $job_sortsearchpage_data);
        $data['uri_segment'] = $uri_segment;
		/* Set Page Title */
		$data['page_title'] = $this->lang->line('common_home_page_title');
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
        } else {
            $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
            $this->load->view('front/include/template', $data);
        }
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

    public function search_by_qualification() {
        $data = [];
        $id = $this->input->post('id');
        $searchopt = '';
        $searchtext = '';
        $date1 = '';
        $date2 = '';
        $searchoption = '';
        $perpage = '';
        $searchtext = $this->input->post('searchtext');
        $perpage = $this->input->post('perpage');
        $allflag = $this->input->post('allflag');
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $this->session->unset_userdata('search_by_sortsearchpage_data');
        }
        $data['sortfield'] = 'id';
        $data['sortby'] = 'desc';
        $search_by_session = $this->session->userdata('search_by_sortsearchpage_data');
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
        $field = array('title', 'slug', 'post_name', 'eligibility', 'total_post', 'last_date', 'is_online', 'is_offline');
        if (!empty($searchtext)) {
            $searchkeyword = @mysqli_real_escape_string(mysqli_init(),html_entity_decode(trim($searchtext)));
            $match = array('post_name' => $searchkeyword, 'board_name' => $searchkeyword, 'total_post' => $searchkeyword, 'qualification' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_master', $field, $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), $match, '', 'like', '', '', '', '', '', '', '1', '');
        } else {
            $data['datalist'] = $this->general_model->select('job_master', $field, '', '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), '', '', '', '', '', '', '', '', '', '1', '');
        }
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
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $job_sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);
        $this->session->set_userdata('job_sortsearchpage_data', $job_sortsearchpage_data);
        $data['uri_segment'] = $uri_segment;
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
        } else {
            $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
            $this->load->view('front/include/template', $data);
        }
        if (!empty($id)) {

        }
    }
}
