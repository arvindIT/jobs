<?php 
/*
    @Description: tips controller
    @Author: Jayesh Rojasara
    @Input: 
    @Output: 
    @Date: 06-05-14
	
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin_user_control extends CI_Controller
{	
    function __construct()
    {
        parent::__construct();
        $this->admin_session = $this->session->userdata('jow_admin_session');
       	$this->message_session = $this->session->userdata('message_session');
        check_admin_login();
		$this->load->model('imageupload_model');
		$this->load->model('common_function_model');
		$this->load->model('admin_model');
		$this->obj = $this->admin_model;
		$this->viewName = $this->router->uri->segments[2];
		$this->user_type = 'admin';
    }
	

    /*
    @Description: Function for Get All tips List
    @Author: Jayesh Rojasara
    @Input: - Search value or null
    @Output: - all tips list
    @Date: 06-05-14
    */
    public function index()
    {	
       	$searchtext = $this->input->post('searchtext');
		$sortfield = $this->input->post('sortfield');
		$sortby = $this->input->post('sortby');
		$searchopt = $this->input->post('searchopt');
		$perpage = $this->input->post('perpage');
		if(!empty($sortfield) && !empty($sortby))
		{
			$sortfield = $this->input->post('sortfield');
			$data['sortfield'] = $sortfield;
			$sortby = $this->input->post('sortby');
			$data['sortby'] = $sortby;
		}
		else
		{
			$sortfield = 'id';
			$sortby = 'desc';
		}
		if(!empty($searchtext))
		{
			$searchtext = $this->input->post('searchtext');
			$data['searchtext'] = $searchtext;
		}
		if(!empty($perpage))
		{
			$perpage = $this->input->post('perpage');
			$data['perpage'] = $perpage;
			$config['per_page'] = $perpage;	
		}
		else
		{
        	$config['per_page'] = '10';
		}
		
	    $config['base_url'] = base_url().'admin/'.$this->viewName;
        //$config['per_page'] = '10';
        $config['next_tag_open'] = '<li >';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['prev_link'] = 'Previous';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="act" >';
        $config['cur_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
	
        $config['uri_segment'] = ($this->uri->segment(3) == 'msg') ? 5 : 3;
        $uri_segment = ($this->uri->segment(3) == 'msg') ? $this->uri->segment(5) : $this->uri->segment(3);
        $data['msg'] = ($this->uri->segment(3) == 'msg') ? $this->uri->segment(4) : '';        
		
		
      	 if(!empty($searchtext))
        {
		  	 $match = array("name"=>$searchtext,"email"=>$searchtext);
		  	 $data['datalist'] = $this->obj->get_user('',$match,'','like','',$config['per_page'], $uri_segment,$sortfield,$sortby);
            $config['total_rows'] = count($this->obj->get_user('',$match,'','like',''));
        }
        else
        {	
			//$fields = array("id","title","description","status");
			$data['datalist'] = $this->obj->get_user('','','','','',$config['per_page'], $uri_segment,$sortfield,$sortby);
            $config['total_rows'] = count($this->obj->get_user());
        }
		$data['msg'] = $this->message_session['msg'];
		
        $this->pagination->initialize($config);
        if(isset($this->modulerights)){$data['modulerights']=$this->modulerights;}
		if($this->input->post('result_type') == 'ajax')
		{
			$this->load->view($this->user_type.'/'.$this->viewName.'/ajax_list',$data);
		}
		else
		{
			$data['main_content'] =  $this->user_type.'/'.$this->viewName."/list";
			$this->load->view('admin/include/template',$data);
		}
    }

    /*
    @Description: Function Add New tips details
    @Author: Jayesh Rojasara
    @Input: - 
    @Output: - Load Form for add tips details
    @Date: 06-05-14
    */
    public function add_record()
    {    
        $data['main_content'] = "admin/".$this->viewName."/add";
        $this->load->view('admin/include/template', $data);
    }

    /*
    @Description: Function for Insert New tips data
    @Author: Jayesh Rojasara
    @Input: - Details of new tips which is inserted into DB
    @Output: - List of tips with new inserted records
    @Date: 06-05-14
    */
    public function insert_data()
    {
		$match = array('email'=>$this->input->post('email'));
        $result = $this->obj->get_user('',$match,'','=');
		if(count($result) > 0)
		{
			$this->session->set_userdata('email_exist','Email already exist');
		}
		else
		{
			$cdata['name'] = $this->input->post('name');
			$cdata['email'] = $this->input->post('email');
			$cdata['password'] = $this->common_function_model->encrypt_script($this->input->post('password'));
			$cdata['createdDate'] = date('Y-m-d H:i:s');
			$cdata['status'] = 1;
			$this->obj->insert_user($cdata);
			$msg = $this->lang->line('common_add_success_msg');
			$newdata = array('msg'  => $msg);
			$this->session->set_userdata('message_session', $newdata);
		}	
        redirect('admin/'.$this->viewName);				
		//redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_add_success_msg'));
    }
    /*
    @Description: Get Details of Edit tips Profile
    @Author: Jayesh Rojasara
    @Input: - Id of tips member whose details want to change
    @Output: - Details of stff which id is selected for update
    @Date: 20-11-2013
    */
    public function edit_record()
    {
        $id = $this->uri->segment(4);
        $data['smenu_title']=$this->lang->line('admin_left_menu15');
        $data['submodule']=$this->lang->line('admin_left_ssclient');
        $match = array('id'=>$id);
        $result = $this->obj->get_user('',$match,'','=');
        $data['editRecord'] = $result;
		$data['main_content'] = "admin/".$this->viewName."/add";       
	   	$this->load->view("admin/include/template",$data);
    }

    /*
    @Description: Function for Update tips Profile
    @Author: Jayesh Rojasara
    @Input: - Update details of tips
    @Output: - List with updated tips details
    @Date: 06-05-14
    */
    public function update_data()
    {
		$cdata['id'] = $this->input->post('id');
		$match = array('email'=>$this->input->post('email'));
        $result = $this->obj->get_user('',$match,'','=');
		if(count($result) > 0 && $result[0]['id']!=$cdata['id'])
		{
			$this->session->set_userdata('email_exist','Email already exist');
		}
		else
		{
			$id = $this->input->post('id');
			$cdata['name'] = $this->input->post('name');
			$cdata['email'] = $this->input->post('email');
			
			$cdata['modifiedDate'] = date('Y-m-d H:i:s');
			$this->obj->update_user($cdata);
			
			$SessionData = $this->session->userdata('jow_admin_session');
			if($SessionData['id'] == $cdata['id'])
			{
				$field = array('id','name','email','status');
				$match = array('id'=>$SessionData['id']);
				$udata = $this->admin_model->get_user($field, $match,'','=');
				$newdata = array(
								'name'  => $udata[0]['name'],
								'id' =>$udata[0]['id'],
								'useremail' =>$udata[0]['email'],
								'active' => TRUE);
				$this->session->set_userdata('jow_admin_session', $newdata);
			}
				
			$msg = $this->lang->line('common_edit_success_msg');
			$newdata = array('msg'  => $msg);
			$this->session->set_userdata('message_session', $newdata);	
		}
		redirect('admin/'.$this->viewName);
		//redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_edit_success_msg'));
        
    }
    /*
    @Description: Function for Delete tips Profile By Admin
    @Author: Jayesh Rojasara
    @Input: - Delete id which tips record want to delete
    @Output: - New tips list after record is deleted.
    @Date: 06-05-14
    */
    function delete_record()
    {
        $id = $this->uri->segment(4);
        $this->obj->delete_user($id);
		$msg = $this->lang->line('common_delete_success_msg');
       	$newdata = array('msg'  => $msg);
       	$this->session->set_userdata('message_session', $newdata);	
        redirect('admin/'.$this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_delete_success_msg'));
    }
	
	 /*
    @Description: Function for Unpublish tips Profile By Admin
    @Author: Jayesh Rojasara
    @Input: - Delete id which tips record want to Unpublish
    @Output: - New tips list after record is Unpublish.
    @Date: 06-05-14
    */
    function unpublish_record()
    {
        $id = $this->uri->segment(4);
		
		$cdata['id'] = $id;
		$cdata['status'] = 0;
		$this->obj->update_user($cdata);
		$msg = $this->lang->line('common_unpublish_msg');
        $newdata = array('msg'  => $msg);
        $this->session->set_userdata('message_session', $newdata);	
		redirect('admin/'.$this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_unpublish_msg'));
    }
	
	/*
    @Description: Function for publish tips Profile By Admin
    @Author: Jayesh Rojasara
    @Input: - Delete id which tips record want to publish
    @Output: - New tips list after record is publish.
    @Date: 06-05-14
    */
	function publish_record()
    {
        $id = $this->uri->segment(4);
				
		$cdata['id'] = $id;
		$cdata['status'] = 1;
		$this->obj->update_user($cdata);
		$msg = $this->lang->line('common_publish_msg');
        $newdata = array('msg'  => $msg);
        $this->session->set_userdata('message_session', $newdata);	
		redirect('admin/'.$this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_publish_msg'));
    }
	
	function upload_image()
	{
			
			$image=$this->input->post('image');
			$hiddenImage=$this->input->post('image');
			$uploadFile = 'uploadfile';
			$bgImgPath = $this->config->item('temp_big_img_path');
			$smallImgPath = $this->config->item('temp_small_img_path');
			$thumb = "thumb";
			$hiddenImage = '';
			echo $this->imageupload_model->uploadBigImage($uploadFile,$bgImgPath,$smallImgPath,$thumb,$hiddenImage);
		
	}
	
	public function ajax_delete_all()
	{
		$array_data=$this->input->post('myarray');
		for($i=0;$i<count($array_data);$i++)
		{
			$this->obj->delete_user($array_data[$i]);
		}
		echo 1;
	}

	public function ajax_publish_all()
	{
		$array_data=$this->input->post('myarray');
		$cdata['status']= '1';
		for($i=0;$i<count($array_data);$i++)
		{
			$cdata['id']= $array_data[$i];
			$this->obj->update_user($cdata);
		}
		echo 1;
	}
	
	public function ajax_unpublish_all()
	{
		$array_data=$this->input->post('myarray');
		$cdata['status']= '0';
		for($i=0;$i<count($array_data);$i++)
		{
			$cdata['id']= $array_data[$i];
			$this->obj->update_user($cdata);
		}
		echo 1;
	}

	
}
