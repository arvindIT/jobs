<?php

/*
  @Description: User controller
  @Author: Ruchi Shahu
  @Input:
  @Output:
  @Date: 28-06-2014

 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_management_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->admin_session = $this->session->userdata('jow_admin_session');
        $this->message_session = $this->session->userdata('message_session');
        check_admin_login();
        $this->load->model('general_model');
        $this->load->model('common_function_model');
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
            $this->session->unset_userdata('user_sortsearchpage_data');
        }
        $data['sortfield'] = 'id';
        $data['sortby'] = 'desc';
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');

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
        $config['base_url'] = site_url($this->user_type . '/' . "user_management/");
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

            $fields = array('*,concat(first_name," ",last_name) as user_name');
            $match = array('first_name' => $searchkeyword, 'last_name' => $searchkeyword, 'email' => $searchkeyword, 'contact_no' => mysql_real_escape_string(trim($searchkeyword)), 'highest_qualification' => mysql_real_escape_string(trim($searchkeyword)), 'location' => mysql_real_escape_string(trim($searchkeyword)));
            $data['datalist'] = $this->general_model->select('jow_users_register_master', $fields, $match, '', 'like', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = count($this->general_model->select('jow_users_register_master', $fields, $match, '', 'like', '', '', '', $sortfield, $sortby));
        } else {
            $fields = array('*,concat(first_name," ",last_name) as user_name');
            $data['datalist'] = $this->general_model->select('jow_users_register_master', $fields, '', '', '', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = count($this->general_model->select('jow_users_register_master', $fields, '', '', '', '', '', '', $sortfield, $sortby));
        }
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['msg'] = $this->message_session['msg'];

        $user_sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']);
        $this->session->set_userdata('user_sortsearchpage_data', $user_sortsearchpage_data);
        $data['uri_segment'] = $uri_segment;
        //pr($data); exit;
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
        } else {
            $data['main_content'] = $this->user_type . '/' . $this->viewName . "/list";
            $this->load->view('admin/include/template', $data);
        }
    }

    public function new_user() {
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
            $this->session->unset_userdata('user_sortsearchpage_data');
        }
        $data['sortfield'] = 'id';
        $data['sortby'] = 'desc';
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');

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
        $config['base_url'] = site_url($this->user_type . '/' . "user_management/new_user/");
        $config['is_ajax_paging'] = TRUE; // default FALSE
        $config['paging_function'] = 'ajax_paging'; // Your jQuery paging
        if (!empty($allflag) && ($allflag == 'all' || $allflag == 'changesorting' || $allflag == 'changesearch')) {
            $config['uri_segment'] = 0;
            $uri_segment = 0;
        } else {
            $config['uri_segment'] = 4;
            $uri_segment = $this->uri->segment(4);
        }
        if (!empty($searchtext)) {
            $searchkeyword = mysql_real_escape_string(html_entity_decode(trim($searchtext)));
            $fields = array('*,concat(first_name," ",last_name) as user_name');
            $condition = array('created_date' => date('Y-m-d'));
            $match = array('first_name' => $searchkeyword, 'last_name' => $searchkeyword, 'email' => $searchkeyword, 'contact_no' => mysql_real_escape_string(trim($searchkeyword)), 'highest_qualification' => mysql_real_escape_string(trim($searchkeyword)), 'location' => mysql_real_escape_string(trim($searchkeyword)));
            $data['datalist'] = $this->general_model->select('jow_users_register_master', $fields, $match, '', 'like', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = count($this->general_model->select('jow_users_register_master', $fields, $match, '', 'like', '', '', '', $sortfield, $sortby));
        } else {
            $fields = array('*,concat(first_name," ",last_name) as user_name');
            $condition = array('DATE(created_date)' => date('Y-m-d'));
            $data['datalist'] = $this->general_model->select('jow_users_register_master', $fields, $condition, '', '=', '', $config['per_page'], $uri_segment, $sortfield, $sortby);
            $config['total_rows'] = count($this->general_model->select('jow_users_register_master', $fields, $condition, '', '=', '', '', '', $sortfield, $sortby));
        }
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['msg'] = $this->message_session['msg'];

        $user_sortsearchpage_data = array(
            'sortfield' => $data['sortfield'],
            'sortby' => $data['sortby'],
            'searchtext' => $data['searchtext'],
            'perpage' => trim($data['perpage']),
            'uri_segment' => $uri_segment,
            'total_rows' => $config['total_rows']
        );

        $this->session->set_userdata('user_sortsearchpage_data', $user_sortsearchpage_data);
        $data['uri_segment'] = $uri_segment;
        if ($this->input->post('result_type') == 'ajax') {
            $this->load->view($this->user_type . '/' . $this->viewName . '/ajax_list', $data);
        } else {
            $data['main_content'] = $this->user_type . '/' . $this->viewName . "/new_user_list";
            $this->load->view('admin/include/template', $data);
        }
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

        $this->general_model->delete('jow_users_register_master', array('id' => $id));

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

    function unpublish_record()
    {
        $id = $this->uri->segment(4);
        $cdata['id'] = $id;
        $cdata['status'] = '0';

        $this->general_model->update('jow_users_register_master', $cdata, array('id' => $id));

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

        //redirect('admin/' . $this->viewName . '/' . $pagingid);
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

        $this->general_model->update('jow_users_register_master', $cdata, array('id' => $id));

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

        //redirect('admin/' . $this->viewName . '/' . $pagingid);
    }

    public function ajax_delete_all() {
        $id = $this->input->post('single_remove_id');
        if (!empty($id)) {
            $this->general_model->delete('jow_users_register_master', array('id' => $id));
            unset($id);
        }

        $array_data = $this->input->post('myarray');
        $delete_all_flag = 0;
        $cnt = 0;
        for ($i = 0; $i < count($array_data); $i++) {
            $this->general_model->delete('jow_users_register_master', array('id' => $array_data[$i]));
            $delete_all_flag = 1;
            $cnt++;
        }

        //pagingation
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
      @Description: Function for check Admin already exist
      @Author: Niral Patel
      @Input: -
      @Output: -
      @Date: 21-07-15
     */

    public function check_user() {
        $id = $this->input->post('id');
        $email = mysql_real_escape_string($this->input->post('email'));
        $match = array('email_id' => $email);
        $exist_email = $this->user_management_model->select_records('', $match, '', '=');

        if (!empty($exist_email)) {
            if ($exist_email[0]['id'] == $id) {
                echo '0';
            } else {
                echo '1';
            }
        } else {
            echo '0';
        }
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
            $this->general_model->update('jow_users_register_master', $cdata, array('id' => $array_data[$i]));
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
            $this->general_model->update('jow_users_register_master', $cdata, array('id' => $array_data[$i]));
        }
        $searchsort_session = $this->session->userdata('user_sortsearchpage_data');
        echo $pagingid = !empty($searchsort_session['uri_segment']) ? $searchsort_session['uri_segment'] : 0;
    }

    function load_user_detals() {
        $user_id = $this->uri->segment(4);
        $user_detail = $this->general_model->select('jow_users_register_master', '', array('id' => $user_id), '', '=');
        $html = '';
        if (!empty($user_detail)) {
            $gender = ($user_detail[0]['gender'] == 2) ? "Femail" : "Male";
            $html .= '<p><strong>User Name</strong> : ' . $user_detail[0]['first_name'] . ' ' . $user_detail[0]['last_name'] . '</p>';
            $html .= '<p><strong>Mobile</strong>  : ' . $user_detail[0]['contact_no'] . '</p>';
            $html .= '<p><strong>Gender</strong>  : ' . $gender . '</p>';
            if (!empty($user_detail[0]['email'])) {
                $html .= '<p><strong>Email</strong>  : ' . $user_detail[0]['email'] . '</p>';
            }
            if (!empty($user_detail[0]['highest_qualification'])) {
                $html .= '<p><strong>Qualification</strong>  : ' . $user_detail[0]['highest_qualification'] . '</p>';
            }
            if (!empty($user_detail[0]['location'])) {
                $html .= '<p><strong>Location</strong>   : ' . $user_detail[0]['location'] . '</p>';
            }
            if (!empty($user_detail[0]['dob'])) {
                $html .= '<p><strong>date of birth</strong>   : ' . $user_detail[0]['dob'] . '</p>';
            }
        }
        echo $html;
        exit;
    }

    function upload_profile() {
        $bgImgPath = $this->config->item('user_pic_img_big');
        $smallImgPath = $this->config->item('user_pic_img_small');
        $id = $this->input->post('id');
        if (!empty($_FILES['user_profile']['name'])) {
            $uploadFile = 'user_profile';
            $thumb = "thumb";
            $hiddenImage = !empty($oldcontactimg) ? $oldcontactimg : '';
            $cdata['pic'] = $this->imageupload_model->uploadBigImage($uploadFile, $bgImgPath, $smallImgPath, $thumb, $hiddenImage);

            $this->general_model->update('jow_users_register_master', $cdata, array('id' => $id));
        }
        $user_id = $id;
        $pagingid = $this->general_model->getuserpagingid('jow_users_register_master', $user_id);
        redirect('admin/' . $this->viewName . '/' . $pagingid);
    }

}
