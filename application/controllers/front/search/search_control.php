<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('common_function_model');
        $this->load->model('general_model');
        $this->lang->load('front', 'english');
        $this->user_type = 'front';
        $this->viewName = 'home';
    }

    public function index()
    {
        /* Slug Array */
        $slug_list = array(
            '1' => 'railway-jobs',
            '2' => 'bank-jobs',
            '3' => 'defence-jobs',
            '7' => 'ssc-jobs',
            '8' => 'psc-jobs',
            '9' => 'other-jobs',
            '10' => 'upsc-jobs',
            '11' => 'state-wise-jobs',
        );
        $search_id = '';
        $slug = $this->uri->segment(2);
        if (!empty($slug)) {
            $search_id = array_keys($slug_list,$slug)[0];
        }

        $data       = [];
        $searchopt  = '';
        $searchtext = '';
        $date1      = '';
        $date2      = '';
        $searchoption = '';
        $perpage    = '';
        $searchtext = $this->input->post('searchtext');
        $perpage    = $this->input->post('perpage');
        $allflag    = $this->input->post('allflag');

        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch'))
        {
            $this->session->unset_userdata('search_by_sortsearchpage_data');
        }
        $data['sortfield']  = 'id';
        $data['sortby']     = 'desc';
        $sortfield          = 'id';
        $sortby             = 'desc';
        $search_by_session  = $this->session->userdata('search_by_sortsearchpage_data');
        if (!empty($searchtext))
        {
            $data['searchtext'] = $searchtext;
        }
        else
        {
            if (empty($allflag))
            {
                if (!empty($searchsort_session['searchtext']))
                {
                    $data['searchtext'] = $searchsort_session['searchtext'];
                    $searchtext = $data['searchtext'];
                }
                else
                {
                    $data['searchtext'] = '';
                }
            }
            else
            {
                $data['searchtext'] = '';
            }
        }
        if (!empty($searchopt))
        {
            $data['searchopt'] = $searchopt;
        }
        if (!empty($date1) && !empty($date2))
        {
            $date1 = $this->input->post('date1');
            $date2 = $this->input->post('date2');
            $data['date1'] = $date1;
            $data['date2'] = $date2;
        }
        if (!empty($perpage) && $perpage != 'null')
        {
            $data['perpage'] = $perpage;
            $config['per_page'] = $perpage;
        }
        else
        {
            if (!empty($searchsort_session['perpage']))
            {
                $data['perpage'] = trim($searchsort_session['perpage']);
                $config['per_page'] = trim($searchsort_session['perpage']);
            }
            else
            {
                $config['per_page'] = '10';
                $data['perpage'] = '10';
            }
        }
        $config['base_url']         = site_url($this->user_type . '/' . "jobs_management/");
        $config['is_ajax_paging']   = TRUE; // default FALSE
        $config['paging_function']  = 'ajax_paging'; // Your jQuery paging
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch'))
        {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        }
        else
        {
            $config['uri_segment'] = 3;
            $uri_segment = $this->uri->segment(3);
        }
        $job_type_table = 'job_type_master as jtm';
        $job_type_field = array('jm.id', 'jm.title', 'jm.slug', 'jm.post_name', 'jm.eligibility', 'jm.total_post', 'jm.last_date', 'jm.is_online', 'jm.is_offline','jm.created_date');
        $join_tables    = array('job_type_trans as jtt' => 'jtt.job_type_id = jtm.id', 'job_master as jm' => 'jm.id = jtt.job_id');
        $join_type      = "LEFT";
        $wherestring    = '';
        if (!empty($search_id))
        {
            $wherestring = "jtt.job_type_id = " . $search_id;
        }
        if (!empty($searchtext))
        {
            $searchkeyword = mysql_real_escape_string(html_entity_decode(trim($searchtext)));
            $match = array('post_name' => $searchkeyword, 'board_name' => $searchkeyword, 'total_post' => $searchkeyword, 'qualification' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_master', $field, $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), $match, '', 'like', '', '', '', '', '', '', '1', '');
        }
        else
        {
            /* Get all job type */
            $data['datalist'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $wherestring);
            //pr($this->db->last_query()); exit;
            $config['total_rows'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', '', '', '', '', '', $wherestring, '', '', 1);
        }

        /* Get all education categories */
        $table = 'qualification_master as qm';
        $categories_field = array('qm.id', 'qm.name', 'count(jqt.id) as counter');
        $join_tables = array('job_qualification_trans as jqt' => 'jqt.job_qualification_id = qm.id');
        $join_type = "LEFT";
        $group_by = 'qm.id';
        $data['categories'] = $this->general_model->getmultiple_tables_records($table, $categories_field, $join_tables, $join_type, '', '', '', '', '', 'qm.priority', 'asc', $group_by);
        $data['total_categories'] = count($this->general_model->select('job_qualification_trans', array('id')));

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
		$data['page_title'] = $this->lang->line('common_search_page_title');
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
        } else {
            $data['main_content'] = $this->user_type . '/' . $this->viewName . "/index";
            $this->load->view('front/include/template', $data);
        }
    }

    public function search_by_qualification() {
        $search_id = '';
        $id = $this->input->post('id');
        if (!empty($id) && $id != 'All') {
            $search_id = $id;
        }
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
        $sortfield = 'id';
        $sortby = 'desc';
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
        $job_type_table = 'qualification_master as qm';
        $job_type_field = array('jm.id', 'jm.title', 'jm.slug', 'jm.post_name', 'jm.eligibility', 'jm.total_post', 'jm.last_date', 'jm.is_online', 'jm.is_offline','jm.created_date');
        $join_tables = array('job_qualification_trans as jqt' => 'jqt.job_qualification_id = qm.id', 'job_master as jm' => 'jm.id = jqt.job_id');
        $join_type = "INNER";
        $field = array('title', 'slug', 'post_name', 'eligibility', 'total_post', 'last_date', 'is_online', 'is_offline');
        $wherestring = '';
        if (!empty($search_id)) {
            $wherestring = "jqt.job_qualification_id = " . $search_id;
        }
        if (!empty($searchtext)) {
            $searchkeyword = @mysqli_real_escape_string(mysqli_init(),html_entity_decode(trim($searchtext)));
            $match = array('post_name' => $searchkeyword, 'board_name' => $searchkeyword, 'total_post' => $searchkeyword, 'qualification' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_master', $field, $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), $match, '', 'like', '', '', '', '', '', '', '1', '');
        } else {
            /* Get all job type */
            $data['datalist'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $wherestring);
            $config['total_rows'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', '', '', '', '', '', $wherestring, '', '', 1);
        }
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
        $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
    }

    public function search_by_job() {
        $search_id = '';
        $id = $this->input->post('id');
        if (!empty($id) && $id != 'All') {
            $search_id = $id;
        }
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
        $sortfield = 'id';
        $sortby = 'desc';
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
        $job_type_table = 'job_type_master as jtm';
        $job_type_field = array('jm.id', 'jm.title', 'jm.slug', 'jm.post_name', 'jm.eligibility', 'jm.total_post', 'jm.last_date', 'jm.is_online', 'jm.is_offline','jm.created_date');
        $join_tables = array('job_type_trans as jtt' => 'jtt.job_type_id = jtm.id', 'job_master as jm' => 'jm.id = jtt.job_id');
        $join_type = "INNER";
        $wherestring = '';
        if (!empty($search_id)) {
            $wherestring = "jtt.job_type_id = " . $search_id;
        }
        if (!empty($searchtext)) {
            $searchkeyword = @mysqli_real_escape_string(mysqli_init(),html_entity_decode(trim($searchtext)));
            $match = array('post_name' => $searchkeyword, 'board_name' => $searchkeyword, 'total_post' => $searchkeyword, 'qualification' => $searchkeyword);
            $data['datalist'] = $this->general_model->select('job_master', $field, $match, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = $this->general_model->select('job_master', array('id'), $match, '', 'like', '', '', '', '', '', '', '1', '');
        } else {
            /* Get all job type */
            $data['datalist'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby, '', $wherestring);
            $config['total_rows'] = $this->general_model->getmultiple_tables_records($job_type_table, $job_type_field, $join_tables, $join_type, '', '', '', '', '', '', '', '', $wherestring, '', '', 1);
        }
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
        $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
    }

}
