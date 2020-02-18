<?php
/*
    @Description: Language add
    @Author: Mit Makwana
    @Date: 03-08-2015

*/?>
<?php
$viewname = $this->router->uri->segments[2];
$formAction = !empty($editRecord)?'update_data':'insert_data';
$path = $viewname.'/'.$formAction;
$head_title = !empty($editRecord)?'Edit User':'Add New User';
?>

<div id="content">
  <div id="content-header">
    <h1><?=$head_title?></h1>
  </div>
  <div id="content-container">
    <div class="row">
      <div class="col-md-12">
        <div class="portlet">
          <div class="portlet-header">
            <h3> <i class="fa fa-user"></i><?=$head_title?></h3>
            	<a class="btn btn-primary pull-right" onclick="history.go(-1)" href="javascript:void(0)">Back</a>
          </div>
          <!-- /.portlet-header -->

          <div class="portlet-content">
            <div class="col-sm-8">
              <form class="form parsley-form" enctype="multipart/form-data" name="<?php echo $viewname;?>" id="<?php echo $viewname;?>" method="post" accept-charset="utf-8" action="<?= $this->config->item('admin_base_url')?><?php echo $path?>" >
                <div class="form-group">
                  <label for="select-multi-input">First name<span style="color:#F00">*</span></label>
                  <input id="first_name" name="first_name" class="form-control parsley-validated" type="text" placeholder="First name" data-required="required" value="<?= !empty($editRecord[0]['first_name'])?$editRecord[0]['first_name']:'';?>" data-required="true">
                </div>
                <div class="form-group">
                  <label for="select-multi-input">Last name<span style="color:#F00">*</span></label>
                  <input id="last_name" placeholder="Last name" name="last_name" class="form-control parsley-validated" type="text" data-required="required" value="<?= !empty($editRecord[0]['last_name'])?$editRecord[0]['last_name']:'';?>" data-required="true">
                </div>
                <div class="form-group">
                  <label for="select-multi-input">Email Id<span style="color:#F00">*</span></label>
                  <input id="email_id" name="email_id" placeholder="Email Id" onblur="check_email(this.value);" class="form-control parsley-validated" type="email" data-required="required" value="<?= !empty($editRecord[0]['email_id'])?$editRecord[0]['email_id']:'';?>" data-required="true">
                </div>
                <?php if(empty($editRecord)) {?>
                 <div class="form-group">
                  <label for="select-multi-input">Password<span style="color:#F00">*</span></label>
                  <input type="password" class="form-control parsley-validated" placeholder="Password" name="password" id="password" class="form-control parsley-validated" data-required="true" data-minlength="6"/>
                </div>
                 <div class="form-group">
                  <label for="select-multi-input">Confirm password<span style="color:#F00">*</span></label>
                  <input type="password" class="form-control parsley-validated" data-equalto="#password" placeholder="Confirm password" name="password" id="password" class="form-control parsley-validated" data-required="true" data-minlength="6"/>
                </div>
                <?php } ?>
                <div class="form-group">
                  <label for="select-multi-input">Address<span style="color:#F00">*</span></label>
                  <textarea  data-required="true" placeholder="Address" class="form-control parsley-validated" id="address" name="address"><?=!empty($editRecord[0]['address'])?$editRecord[0]['address']:'';?></textarea>
                </div>

                <div class="form-group">
                  <label for="select-multi-input">Post code<span style="color:#F00">*</span></label>
                  <input id="post_code" placeholder="Post code" name="post_code" onkeypress="return isNumberKey(event, this);" class="form-control parsley-validated" type="text" data-required="required" value="<?= !empty($editRecord[0]['post_code'])?$editRecord[0]['post_code']:'';?>" data-required="true">
                </div>
                <div class="form-group">
                  <label for="select-multi-input">Phone no </label>
                  <input id="phone_no" name="phone_no" placeholder="Phone no" onkeypress="return isNumberKey(event, this);" class="form-control parsley-validated mask_apply_class" type="text" value="<?= !empty($editRecord[0]['phone_no'])?$editRecord[0]['phone_no']:'';?>">
                </div>
                <?php //pr($editRecord); ?>
                 <div class="form-group">
                  <label for="select-multi-input">Birth date </label>
                  <input id="birth_date" name="birth_date" placeholder="Birth date" class="form-control parsley-validated" type="text" value="<?= !empty($editRecord[0]['birth_date'])?$editRecord[0]['birth_date']:'';?>">
                </div>

                 <div class="form-group">
                  <label for="select-multi-input">Gender <span style="color:#F00">*</span></label>
                   <select class="form-control parsley-validated selectBox" name='gender' id='gender' data-required="true">
                        <option value="">Select Gender</option>
                        <option <?= !empty($editRecord[0]['gender']) ? ($editRecord[0]['gender'] == 1) ? 'selected=selected' : '' : ''; ?> value="1" >Male</option>
                        <option <?= !empty($editRecord[0]['gender']) ? ($editRecord[0]['gender'] == 2) ? 'selected=selected' : '' : ''; ?> value="2" >Female</option>
                    </select>
                </div>

                <div class="form-group">
                  <input type="hidden" name="id" id="id" value="<?= !empty($editRecord[0]['id'])?$editRecord[0]['id']:'';?>" />
                  <button type="submit" onclick="return setdefaultdata();" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
          </div>
          <!-- /.portlet-content -->

        </div>
      </div>
    </div>
  </div>
  <!-- #content-header -->

  <!-- /#content-container -->

</div>
<!-- #content -->
<script type="text/javascript">
function setdefaultdata()
{
    if ($('#<?php echo $viewname ?>').parsley().isValid()) {
        $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
    }
}


$('#phone_no').mask('(999) 999-9999');
function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode
  if (charCode > 31 && (charCode < 48 || charCode > 57))
    return false;

  return true;
}
function check_email(email)
{
  var id = $('#id').val();
  $.ajax({
        type: "POST",
        url: "<?php echo base_url().'admin/user_management/check_user';?>",
        dataType: 'json',
        async: false,
        data: {'email':email,'id':id},
        /*beforeSend: function() {
          $.blockUI({ message: '<?='<img src="'.base_url('images').'/ajaxloader.gif" border="0" align="absmiddle"/>'?>'})
        },*/
        success: function(data){
        if(data == '1')
        {$('#email_id').focus();
        $('#submit').attr('disabled','disabled');

          $.confirm({'title': 'Alert','message': " <strong> This email already existing. Please select other email. "+"<strong></strong>",'buttons': {'ok'  : {'class'  : 'btn_center alert_ok','action': function(){
                    $('#email_id').focus();
                    $('#submit').removeAttr('disabled');
                    //$.unblockUI();
                  }}}});

        }
        else
          $.unblockUI();
        }
      });
      return false;

}
$(document).ready(function(){
$('#birth_date').datepicker({
      showTimePicker: false,
      dateFormat: "mm/dd/yy",
      altFieldTimeOnly: false,
      showOtherMonths: true,
      selectOtherMonths: true,
    });
});
</script>