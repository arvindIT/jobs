<?php 
/*
    @Description: Player controller
    @Author: Ruchi Shahu
    @Input: 
    @Output: 
    @Date: 16-07-14
	
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_control extends CI_Controller
{	
    function __construct()
    {
		parent::__construct();
		$this->load->model('ws/user_model');
		$this->load->model('common_function_model');
		
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
   function index()
	{	
		//$postData = $_REQUEST;
 		//extract($_REQUEST);

 		//if($_REQUEST['func'] == 'getuser')
			//$this->getuser($postData);
 		

	}

    /*
    @Description: Function Add New Player details
    @Author: Ruchi Shahu
    @Input: - 
    @Output: - Load Form for add Player details
    @Date: 16-07-14
    */
    public function getuser()
    {
	//echo 1;exit;
		$post_data = $_REQUEST;
		//pr($post_data);exit;
		$match='';$match1=array();$match2=array();
		if(isset($post_data['name']) && !empty($post_data['name']))
		{
			 $match1 = array("CONCAT(first_name,' ',last_name)"=>$post_data['name']);

		}
		if(isset($post_data['email_address']) && !empty($post_data['email_address']))
		{
			 $match2 = array('email_address'=>$post_data['email_address']);

		}
		
		if(!empty($post_data))
		{	
			$match=array_merge($match1,$match2);
			$data = $this->obj->select_records('',$match,'','like','','', '','id','desc');  
			//echo $this->db->last_query();
		}
		else
		{
			$data = $this->obj->select_records('','','','','','', '','id','desc');
		}
        
		//pr($data);exit;
		if(!empty($data))
		{
			$arr['MESSAGE']='SUCCESS';
			$arr['FLAG']=true;
			$arr['data']=$data;
		}
		else
		{
			$arr['MESSAGE']='FAIL';
			$arr['FLAG']=false;
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
    public function insert_data()
    {
		$match = array('email_address'=>$this->input->get('email_address'));
        $result = $this->obj->select_records('',$match,'','=');
		if(count($result) > 0)
		{
			$this->session->set_userdata('email_exist','Email already exist');
		}
		else
		{
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
			 pr($cdata);exit;
			$name = $cdata['first_name']." ".$cdata['last_name'];
			$created_midified_id = $this->obj->insert_record($cdata);	
			// $this->email($cdata['email_address'],$name,$password);
			$msg = $this->lang->line('common_add_success_msg');
			$newdata = array('msg'  => $msg);
			$this->session->set_userdata('message_session', $newdata);	
		}
        redirect('admin/'.$this->viewName);				
		//redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_add_success_msg'));
    }
    /*
    @Description: Get Details of Edit Player
    @Author: Ruchi Shahu
    @Input: - Id of Player member whose details want to change
    @Output: - Details of Player which id is selected for update
    @Date: 16-07-2013
    */
    public function edit_record()
    {
        $id = $this->uri->segment(4);
		$data['team_datalist'] = $this->team_model->select_records('','','','','','', '','id','desc');
        $data['smenu_title']=$this->lang->line('admin_left_menu15');
        $data['submodule']=$this->lang->line('admin_left_ssclient');
        $fields = array('id,name');
        $match = array('id'=>$id);
        $result = $this->obj->select_records('',$match,'','=');
        $data['editRecord'] = $result;
		$data['main_content'] = "admin/".$this->viewName."/add";       
	   	$this->load->view("admin/include/template",$data);
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
		$match = array('email_address'=>$this->input->post('email_address'));
        $result = $this->obj->select_records('',$match,'','=');
		if(count($result) > 0 && $result[0]['id']!=$cdata['id'])
		{
			$this->session->set_userdata('email_exist','Email already exist');
		}
		else
		{
			$cdata['id'] = $this->input->post('id');
			$cdata['first_name'] = $this->input->post('first_name');
			$cdata['last_name'] = $this->input->post('last_name');
			$cdata['email_address'] = $this->input->post('email_address');
			$pass = $this->input->post('password');
			if(!empty($pass))
			{	
				$cdata['password'] =  $this->common_function_model->encrypt_script($this->input->post('password'));
			}
			
			$cdata['mobile_no'] = $this->input->post('mobile_no');
			$cdata['user_type'] = $this->input->post('user_type');
   
			$cdata['modified_date'] = date('Y-m-d H:i:s');		
			$cdata['status'] = 1;
    
			$this->obj->update_record($cdata);			
			
			// Update Player Name in Team Management
			$result = $this->player_model->select_player_trans($this->input->post('id'));
			if(count($result) > 0)
			{
				$traData['player_id'] 	= $result[0]['player_id'];
				$traData['player_name'] = $cdata['first_name']." ".$cdata['last_name'];
				$this->obj->update_player_trans($traData);	
			}
			
			// Update Player1 Name OR Player2 Name in championship_team_trans table
			$match_id =array('is_completed'=>'0');
			$get_championship_id = $this->championship_model->select_records('',$match_id,'','=');
			
			if(count($get_championship_id) > 0)
			{
				$champtra['championship_id'] = $get_championship_id[0]['id'];
				$champtra['player1_id'] = $this->input->post('id');
				$champtra['player2_id'] = $this->input->post('id');
				$get_championship_trans_id = $this->selected_team_model->select_champ_records($champtra);
				//pr($get_championship_trans_id);exit;
				if(!empty($get_championship_trans_id))
				{
					$champtraData['championship_id'] = $get_championship_id[0]['id'];
					if($get_championship_trans_id[0]['player1_id'] == $champtra['player1_id'])
					{
						$champtraData['player1_id'] = $cdata['id'];
						$champtraData['player1_name'] = $cdata['first_name']." ".$cdata['last_name'];
						$this->selected_team_model->update_player1_record($champtraData);	
					}
					else
					{					
						$champtraData['player2_id'] = $cdata['id'];
						$champtraData['player2_name'] = $cdata['first_name']." ".$cdata['last_name'];
						$this->selected_team_model->update_player1_record($champtraData);	
					}
				}
			}// END
			
			/*if(!empty($get_championship_id) && !empty($get_championship_trans_id))
			{
				if($get_championship_id[0]['is_completed'] == $get_championship_trans_id[0]['championship_id'])
				{
					$player_id = $this->input->post('id');
					$champ_trans_player = $this->selected_team_model->select_records_player_id($player_id);
					if($champ_trans_player[0]['player1_id'] == $player_id)
					{
						$champtraData['player1_name'] = $cdata['first_name']." ".$cdata['last_name'];
						$this->selected_team_model->update_player1_record($champtraData);	
					}
					else
					{
						$champtraData['player2_name'] = $cdata['first_name']." ".$cdata['last_name'];
						$this->selected_team_model->update_player2_record($champtraData);	
					}
				}
				else{
					echo "no";
					exit;
				}
			}*/
			
			/*
			// Update Player Name in  Game Score Management 
			$match_id =array('player_id'=>$this->input->post('id'));
			$game_player_id = $this->game_score_model->select_records('',$match_id,'','=');
			*/
			
			$msg = $this->lang->line('common_edit_success_msg');
			$newdata = array('msg'  => $msg);
			$this->session->set_userdata('message_session', $newdata);	
		}
		$player_id = $this->input->post('id');
		$pagingid = $this->obj->getplayerpagingid($player_id);
		//echo $pagingid;exit;
		redirect('admin/'.$this->viewName.'/'.$pagingid);
		//redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_edit_success_msg'));
        
    }
    /*
    @Description: Function for Delete Player By Admin
    @Author: Ruchi Shahu
    @Input: - Delete id which Player record want to delete
    @Output: - New Player list after record is deleted.
    @Date: 16-07-14
    */
    function delete_record()
    {
        $id = $this->uri->segment(4);
		
		/*$current_championship = $this->team_model->select_championship_id();
		if(!empty($current_championship[0]['id']))
		{
			$championship_id=$current_championship[0]['id'];
			$pteamdata = $this->team_model->select_team_player_id($id);
			if(!empty($pteamdata[0]['team_id']))
			{
				$teamdata = $this->pool_model->select_championship_team_id($championship_id,$pteamdata[0]['team_id']);
				if(count($teamdata) > 0)
				{?>
					<script type="text/javascript">
						alert('Player can not be deleted. Pool is already generated.');
						window.location.href = '<?=base_url().'admin/'.$this->viewName;?>';
					</script>
				<?php exit; }
			}
		}*/
		
        $returnmsg = $this->obj->delete_record($id);
		
		if($returnmsg == 'fail')
		{
			?>
					<script type="text/javascript">
						alert('Player can not be deleted. Already assign to a team.');
						window.location.href = '<?=base_url().'admin/'.$this->viewName;?>';
					</script>
				<?php exit;
		}
		
		$msg = $this->lang->line('common_delete_success_msg');
       	$newdata = array('msg'  => $msg);
       	$this->session->set_userdata('message_session', $newdata);	
        redirect('admin/'.$this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_delete_success_msg'));
    }
	
	 /*
    @Description: Function for Unpublish Player By Admin
    @Author: Ruchi Shahu
    @Input: - Delete id which Player record want to Unpublish
    @Output: - New Player list after record is Unpublish.
    @Date: 16-07-14
    */
    function unpublish_record()
    {
        $id = $this->uri->segment(4);
		
		$cdata['id'] = $id;
		$cdata['status'] = 0;
		$this->obj->update_record($cdata);
		$msg = $this->lang->line('common_unpublish_msg');
        $newdata = array('msg'  => $msg);
        $this->session->set_userdata('message_session', $newdata);	
		redirect('admin/'.$this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_unpublish_msg'));
    }
	
	/*
    @Description: Function for publish Player By Admin
    @Author: Ruchi Shahu
    @Input: - Delete id which Player record want to publish
    @Output: - New Player list after record is publish.
    @Date: 16-07-14
    */
	function publish_record()
    {
        $id = $this->uri->segment(4);
				
		$cdata['id'] = $id;
		$cdata['status'] = 1;
		$this->obj->update_record($cdata);
		$msg = $this->lang->line('common_publish_msg');
        $newdata = array('msg'  => $msg);
        $this->session->set_userdata('message_session', $newdata);	
		redirect('admin/'.$this->viewName);
        //redirect('admin/'.$this->viewName.'/msg/'.$this->lang->line('common_publish_msg'));
    }
	
	public function ajax_delete_all()
	{
		$array_data=$this->input->post('myarray');
		for($i=0;$i<count($array_data);$i++)
		{
			$this->obj->delete_record($array_data[$i]);
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
			$this->obj->update_record($cdata);
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
			$this->obj->update_record($cdata);
		}
		echo 1;
	}
	
	 public function randr($j = 8) {
        $string = "";
        for ($i = 0; $i < $j; $i++) {
            srand((double) microtime() * 1234567);
            $x = mt_rand(0, 2);
            switch ($x) {
                case 0:$string.= chr(mt_rand(97, 122));
                    break;
                case 1:$string.= chr(mt_rand(65, 90));
                    break;
                case 2:$string.= chr(mt_rand(48, 57));
                    break;
            }
        }
        return strtoupper($string);
    }
	
	public function email($username,$name,$password)
	{
		$subject = " Tournament : Password ";                    
           
		$img = $this->config->item('base_url')."images/logo.png";
		        
		$msg = '<table align="center" bgcolor="#eeeeef" frame="box" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" height="0" valign="top" width="600">
				<tbody>
						<tr>
							<td align="center" height="80" valign="middle" style="background:#EE2F2E; background-repeat:repeat-x;background-size:100% 100%; width:100%" >
								<img alt="Tournament" src="'.$img.'"/>
							</td>
						</tr>
				</tbody>
		</table>
		<table align="center" cellpadding="10" frame="box" bgcolor="#fff" cellpadding="0" cellspacing="0" height="300" valign="top" width="600">
				<tbody>
						<tr>
								<td height="20" valign="middle" width="215">
										Dear '.ucfirst($name).',</td>
						</tr>
						
						<tr>
								<td height="20" valign="middle" width="215">
										Your password is: <b>'.$password.'</b></td>
						</tr>
						<tr>
								<td height="20" valign="middle" width="215">
										<p>
												Thanks,<br />
												<br />
												Tournament</p>
								</td>
						</tr>
				</tbody>
		</table>
		<table align="center" bgcolor="#eeeeef" frame="box" border="1" bordercolor="#666666" cellpadding="0" cellspacing="0" height="0" valign="top" width="600">
				<tbody>
						<tr>
							<td align="center" height="40" valign="middle" style="background:#EE2F2E; background-repeat:repeat-x;background-size:100% 100%; width:100%" >
								<h5 style="margin:auto;color:white">Copyright 2014 &copy; Tournament</h5>
							</td>
						</tr>
				</tbody>
		</table>';
		
		$to = $username;
		$from = $this->config->item('email_send_from');
		$full_name = 'Tournament';
		$from = $full_name.'<'.$from.'>';
		$headers = "From: " . $from . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		mail($to,$subject,$msg,$headers);
	}

}
