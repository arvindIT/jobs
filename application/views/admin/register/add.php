<?php
$viewname = $this->router->uri->segments[2];
$formAction = !empty($editRecord) ? 'update_data' : 'insert_data';
$path = $viewname . '/' . $formAction;
$is_edit = !empty($editRecord) ? "Edit" : "Add New";
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Registration Form</h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="registration-form" method="post" action="" data-parsley-validate class="form parsley-form form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name"><?= $this->lang->line('common_label_first_name')?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="first-name" name="user_first_name" data-required="true" class="form-control col-md-7 col-xs-12" value="<?= !empty($editRecord[0]['first_name'])?$editRecord[0]['first_name']:''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?= $this->lang->line('common_label_last_name')?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="last-name" name="user_last_name" data-required="true" class="form-control col-md-7 col-xs-12" value="<?= !empty($editRecord[0]['last_name'])?$editRecord[0]['last_name']:''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_email" class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('common_label_email')?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" id="user_email" name="user_email" class="form-control parsley-validated" data-parsley-type="email" value="<?= !empty($editRecord[0]['email'])?$editRecord[0]['email']:''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_birthday" class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('common_label_date_of_birth')?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="user_birthday" class="date-picker form-control col-md-7 col-xs-12" name="user_birthday" type="text" value="<?= !empty($editRecord[0]['dob']) && $editRecord[0]['dob'] != "0000-00-00"? date("d/m/Y", strtotime($editRecord[0]['dob'])):''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_mobile" class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('common_label_mobile')?> <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="user_mobile" name="user_mobile" class="form-control parsley-validated" type="text" data-required="true" maxlength="10" data-minlength='10' onkeypress="return isNumberKey(event)" value="<?= !empty($editRecord[0]['contact_no'])?$editRecord[0]['contact_no']:''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_highest_qualification" class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('common_label_highest_qualification')?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="user_highest_qualification" class="form-control col-md-7 col-xs-12" type="text" name="usre_highest_qualification" value="<?= !empty($editRecord[0]['highest_qualification'])?$editRecord[0]['highest_qualification']:''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="user_location" class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('common_label_highest_location')?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input id="user_location" class="form-control col-md-7 col-xs-12" type="text" name="user_location" value="<?= !empty($editRecord[0]['location'])?$editRecord[0]['location']:''?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12"><?= $this->lang->line('common_label_gender')?> <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="user_gender" class="btn-group" data-toggle="buttons">
                                        <?php
                                        $checked_value = 1;
                                        if(!empty($editRecord[0]['gender']))
                                        {
                                            if($editRecord[0]['gender'] == 2)
                                            {
                                              $checked_value = 2;
                                            }
                                        }
                                        ?>
                                        <label class="btn btn-default <?= ($checked_value == 1)?'active':''?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="user_gender" value="1" <?= ($checked_value == 1)?'checked':''?>> &nbsp; Male &nbsp;
                                        </label>
                                        <label class="btn btn-default <?= ($checked_value == 2)?'active':''?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                            <input type="radio" name="user_gender" value="2" <?= ($checked_value == 2)?'checked':''?>> Female
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="hidden" name="user_id" id="user_id" value="<?= !empty($editRecord[0]['id']) ? $editRecord[0]['id'] : ''  ?>" />
                                    <button type="button" onclick="saveformdata()"  class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function()
    {
        $('#user_birthday').datetimepicker({
            format: 'DD/MM/YYYY'
        });
    });
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    function saveformdata()
    {
        $('#registration-form').parsley().validate();
        if ($('#registration-form').parsley().isValid())
        {
            $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('admin_base_url') . $viewname . '/'.$formAction; ?>",
                data: $('#registration-form').serialize(),
                beforeSend: function () {
                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (data) {
					//return false;
                    window.location.href = "<?php echo $this->config->item('admin_base_url') . 'user_management'; ?>";
                }
            });
            return false;
        }
    }
    function showprofileimagepreview(input, i)
    {
        var i = i.substring(13, 25);
        var arr1 = input.files[0]['name'].split('.');
        var arr = arr1[arr1.length - 1].toLowerCase();
        if (input.files.length <= 5) {
            if (arr == 'jpg' || arr == 'jpeg' || arr == 'png' || arr == 'bmp' || arr == 'gif') {
               var filerdr = new FileReader();
                filerdr.onload = function (e) {
                    if (i == '1')
                    {
                        $('#upload_profile_preview').attr('src', e.target.result);
                        $('.delete_proifle_img_div_button').removeClass('hidden');
                    }
                    else
                    {
                        $('#upload_profile_preview').attr('src', e.target.result);
                        $('.delete_proifle_img_div_button').removeClass('hidden');
                    }
                }
                filerdr.readAsDataURL(input.files[0]);
            }else{
                $.confirm({'title': 'Alert', 'message': " <strong> Please upload jpg | jpeg | png | bmp | gif file only. " + "<strong></strong>", 'buttons': {'ok': {'class': 'btn_center alert_ok'}}});
                $('#user_pic').val('');
                return false;
            }
        }
        else
        {
            $.confirm({'title': 'Alert', 'message': " <strong> You can upload maximum 5 images. " + "<strong></strong>", 'buttons': {'ok': {'class': 'btn_center alert_ok'}}});
            return false;
        }
    }

    function delete_profile_image(e,Id)
    {
        $.confirm({
        'title': 'CONFIRM','message': " <strong> Are you sure want to delete logo ?",'buttons': {'Yes': {'class': 'special btn_ok',
        'action': function(){
            $.ajax({
                type  : "POST",
                url   : "<?=$this->config->item('admin_base_url').$viewname; ?>/delete_image_record_ajax",
                data  : {
                    result_type:'ajax',id:Id
                },
                success : function(html){
                    $('#upload_profile_preview').attr('src', '<?= base_url('images/no_image.jpg') ?>');
                    $('.delete_proifle_img_div_button').addClass('hidden');
                }
              });
              return false;
            }},'No' : {'class'  : ''}}});
    }
</script>