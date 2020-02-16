<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_control extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('ws/user_model');
        $this->load->model('common_function_model');
        $this->load->model('general_model');
        $this->obj = $this->user_model;
        $this->viewName = $this->router->uri->segments[2];
        $this->user_type = 'admin';
    }

    /*
      @Description: Function for Get All Player List
      @Author: Ruchi Shahu
      @Input: - Search value or null
      @Output: - all tips list
      @Date: 16-07-14
     */

    function index() {
        //$postData = $_REQUEST;
        //extract($_REQUEST);
        //if($_REQUEST['func'] == 'getuser')
        //$this->getuser($postData);
    }

    /*     * *********************************************************************************************
      @Description		: Display the List of user
      @Author     		: Niral Patel
      @input     			:
      @Output     		:
      @Date       		:
      @Webservices link   http://192.168.0.54/master_panel/ws/user/getuser?name=Robert
      @Webservices link   http://192.168.0.54/master_panel/ws/user/getuser

     * ********************************************************************************************** */

    public function getuser() {
        //echo 1;exit;
        $post_data = $_REQUEST;
        //pr($post_data);exit;
        $match = '';
        if (isset($post_data['name']) && !empty($post_data['name'])) {
            $match = array("CONCAT(first_name,' ',last_name)" => $post_data['name']);
        }
        if (!empty($post_data)) {
            $data = $this->obj->select_records('', $match, '', 'like', '', '', '', 'id', 'desc');
        } else {
            $data = $this->obj->select_records('', '', '', '', '', '', '', 'id', 'desc');
        }
        if (!empty($data)) {
            $arr['MESSAGE'] = 'SUCCESS';
            $arr['FLAG'] = true;
            $arr['data'] = $data;
        } else {
            $arr['MESSAGE'] = 'FAIL';
            $arr['FLAG'] = false;
        }
        echo json_encode($arr);
    }

    /*
      @Description: Function for Insert New Player data
      @Author: Ruchi Shahu
      @Input: - Details of new Player which is inserted into DB
      @Output: - List of tips with new inserted records
      @Date: 16-07-14
     */

    public function insert_data() {
        $match = array('email_address' => $this->input->get('email_address'));
        $result = $this->obj->select_records('', $match, '', '=');
        if (count($result) > 0) {
            $this->session->set_userdata('email_exist', 'Email already exist');
        } else {
            $cdata['created_by'] = 1;
            $cdata['first_name'] = $this->input->get('first_name');
            $cdata['last_name'] = $this->input->get('last_name');
            $cdata['email_address'] = $this->input->get('email_address');
            $password = $this->randr(8);
            $cdata['password'] = $this->common_function_model->encrypt_script($password);
            $cdata['mobile_no'] = $this->input->get('mobile_no');
            $cdata['user_type'] = $this->input->get('user_type');
            $cdata['created_date'] = date('Y-m-d H:i:s');
            $cdata['status'] = 1;
            pr($cdata);
            exit;
            $name = $cdata['first_name'] . " " . $cdata['last_name'];
            $created_midified_id = $this->obj->insert_record($cdata);
            // $this->email($cdata['email_address'],$name,$password);
            $msg = $this->lang->line('common_add_success_msg');
            $newdata = array('msg' => $msg);
            $this->session->set_userdata('message_session', $newdata);
        }
        redirect('admin/' . $this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_add_success_msg'));
    }

    /*
      @Description: Function for Update Player
      @Author: Ruchi Shahu
      @Input: - Update details of Player
      @Output: - List with updated Player details
      @Date: 16-07-14
     */

    public function update_data()
    {
        $cdata['id'] = $this->input->post('id');
        $match = array('email_address' => $this->input->post('email_address'));
        $result = $this->obj->select_records('', $match, '', '=');
        if (count($result) > 0 && $result[0]['id'] != $cdata['id']) {
            $this->session->set_userdata('email_exist', 'Email already exist');
        } else {
            $cdata['id'] = $this->input->post('id');
            $cdata['first_name'] = $this->input->post('first_name');
            $cdata['last_name'] = $this->input->post('last_name');
            $cdata['email_address'] = $this->input->post('email_address');
            $pass = $this->input->post('password');
            if (!empty($pass)) {
                $cdata['password'] = $this->common_function_model->encrypt_script($this->input->post('password'));
            }

            $cdata['mobile_no'] = $this->input->post('mobile_no');
            $cdata['user_type'] = $this->input->post('user_type');

            $cdata['modified_date'] = date('Y-m-d H:i:s');
            $cdata['status'] = 1;

            $this->obj->update_record($cdata);

            // Update Player Name in Team Management
            $result = $this->player_model->select_player_trans($this->input->post('id'));
            if (count($result) > 0) {
                $traData['player_id'] = $result[0]['player_id'];
                $traData['player_name'] = $cdata['first_name'] . " " . $cdata['last_name'];
                $this->obj->update_player_trans($traData);
            }

            // Update Player1 Name OR Player2 Name in championship_team_trans table
            $match_id = array('is_completed' => '0');
            $get_championship_id = $this->championship_model->select_records('', $match_id, '', '=');

            if (count($get_championship_id) > 0) {
                $champtra['championship_id'] = $get_championship_id[0]['id'];
                $champtra['player1_id'] = $this->input->post('id');
                $champtra['player2_id'] = $this->input->post('id');
                $get_championship_trans_id = $this->selected_team_model->select_champ_records($champtra);
                //pr($get_championship_trans_id);exit;
                if (!empty($get_championship_trans_id)) {
                    $champtraData['championship_id'] = $get_championship_id[0]['id'];
                    if ($get_championship_trans_id[0]['player1_id'] == $champtra['player1_id']) {
                        $champtraData['player1_id'] = $cdata['id'];
                        $champtraData['player1_name'] = $cdata['first_name'] . " " . $cdata['last_name'];
                        $this->selected_team_model->update_player1_record($champtraData);
                    } else {
                        $champtraData['player2_id'] = $cdata['id'];
                        $champtraData['player2_name'] = $cdata['first_name'] . " " . $cdata['last_name'];
                        $this->selected_team_model->update_player1_record($champtraData);
                    }
                }
            }// END
            $msg = $this->lang->line('common_edit_success_msg');
            $newdata = array('msg' => $msg);
            $this->session->set_userdata('message_session', $newdata);
        }
        $player_id = $this->input->post('id');
        $pagingid = $this->obj->getplayerpagingid($player_id);
        redirect('admin/' . $this->viewName . '/' . $pagingid);
    }

    /*
      @Description: Function for Delete Player By Admin
      @Author: Ruchi Shahu
      @Input: - Delete id which Player record want to delete
      @Output: - New Player list after record is deleted.
      @Date: 16-07-14
     */

    function delete_record() {
        $id = $this->uri->segment(4);
        $returnmsg = $this->obj->delete_record($id);
        redirect('admin/' . $this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_delete_success_msg'));
    }

    function auto_cron()
    {
        /* Get all jobs */
        $job_data = $this->general_model->select('job_master',array('id','short_url'), array('status' => 1), '', '=', '', '5');
        if(!empty($job_data))
        {
            foreach ($job_data as $key => $job)
            {?>
                <script type='text/javascript'>
                    var url = "<?php echo !empty($job['short_url']) ? $job['short_url'] : ''; ?>";
                    //setTimeout("window.close()", 5000);
                    var myWindow = window.open(url, '_blank');
                    setTimeout(function(){
                        myWindow.close();
                    }, 10000);
                </script>

            <?php }
        }
    }

}
