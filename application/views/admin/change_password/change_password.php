<?php
/*
    @Description: Contact add
    @Author: Niral Patel
    @Date: 30-06-2014

*/?>


<?php 
$admin_type = $this->router->uri->segments[1];
$viewname = $this->router->uri->segments[2];
$session_data = $this->session->userdata('change_password_session');
print_r($session_data);
?>
<div id="content">
  <div id="content-header">
   <h1>Change Password</h1>
  </div>
  <div id="content-container">
   <div class="row">
    <div class="col-md-12">
     <div class="portlet">
						<div class="portlet-header">
							<h3>
								<i class="fa fa-key"></i>
								 Change password
							</h3>
							<a class="btn btn-danger pull-right mrg12" onclick="history.go(-1)" href="javascript:void(0)">Back</a>

						</div> <!-- /.portlet-header -->

						<div class="portlet-content">
                        <div class="col-sm-8">

							 <form class="form parsley-form" enctype="multipart/form-data" name="<?php echo $viewname;?>" id="<?php echo $viewname;?>" method="post" accept-charset="utf-8" action="<?= $this->config->item('admin_base_url')?>change_password/admin_change_password" >	
					
							 	<?php if(isset($session_data)) { ?>
							 	<div class="col-sm-12 text-center" id="div_msg">
									<span style="color:#F00">	<?php echo $session_data; 
									 $this->session->unset_userdata('change_password_session');
									?></span>
								</div>
								<?php } ?>
							 	<div class="form-group">
									<label for="select-multi-input">Old Password<span style="color:#F00">*</span></label>
									<input data-minlength="6" type="password" name="oldpassword" id="oldpassword" class="form-control parsley-validated" type="text" data-required="true"  placeholder="Change password"/>
								</div>
								
                                <div class="form-group">
									<label for="select-multi-input">New password<span style="color:#F00">*</span></label>
									<input data-minlength="6" type="password" name="password" id="password" class="form-control parsley-validated" placeholder="New password" type="text" data-required="true" />
								</div>
                               <div class="form-group">
									<label for="select-multi-input">New confirm password<span style="color:#F00">*</span></label>
									<input type="password" name="cpassword" placeholder="New confirm password" id="cpassword" class="form-control parsley-validated" type="text" data-required="true" data-equalto="#password" />
								</div>
								<div class="form-group">
                                <input type="hidden" name="id" value="<?= !empty($editRecord[0]['id'])?$editRecord[0]['id']:'';?>" />
									<button type="submit" class="btn btn-danger" >Save</button>
								</div>

							</form>
</div>
						</div> <!-- /.portlet-content -->

					</div>
    </div>
   </div>
  </div>
  <!-- #content-header --> 
  
  <!-- /#content-container --> 
  
 </div>
 

 <!-- #content --> 
 <script>
  $(document).ready(function(){
	 $("#div_msg").fadeOut(4000); 
    });
 </script>
 