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
                        <h2><?php echo $this->lang->line('common_label_qualification_form'); ?></h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="qualification-form" method="post" action="" data-parsley-validate class="form parsley-form form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name"><?php echo $this->lang->line('common_label_qualification_name')?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="name" name="name" data-required="true" class="form-control col-md-7 col-xs-12" value="<?= !empty($editRecord[0]['name'])?$editRecord[0]['name']:''?>">
                                </div>
                            </div>
							<div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="priority"><?php echo $this->lang->line('common_label_priority')?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="priority" name="priority" data-required="true" class="form-control col-md-7 col-xs-12" value="<?= !empty($editRecord[0]['priority'])?$editRecord[0]['priority']:''?>" onkeypress="return isNumberKey(event)">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <input type="hidden" name="id" id="id" value="<?= !empty($editRecord[0]['id']) ? $editRecord[0]['id'] : ''  ?>" />
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
	function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    function saveformdata()
    {
        $('#qualification-form').parsley().validate();
        if ($('#qualification-form').parsley().isValid())
        {
            $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('admin_base_url') . $viewname . '/'.$formAction; ?>",
                data: $('#qualification-form').serialize(),
                beforeSend: function () {
                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (data) {
                    window.location.href = "<?php echo $this->config->item('admin_base_url') . 'qualification_management'; ?>";
                }
            });
            return false;
        }
    }
</script>