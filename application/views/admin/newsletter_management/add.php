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
                        <h2><?php echo $this->lang->line('common_label_newsletter_form'); ?></h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="newsletter-form" method="post" action="" data-parsley-validate class="form parsley-form form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email_id"><?php echo $this->lang->line('common_email_title')?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="email" id="email_id" name="email_id" data-required="true" data-parsley-type="email" class="form-control col-md-7 col-xs-12" value="<?= !empty($editRecord[0]['email_id'])?$editRecord[0]['email_id']:''?>">
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
    function saveformdata()
    {
        $('#newsletter-form').parsley().validate();
        if ($('#newsletter-form').parsley().isValid())
        {
            $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
            $.ajax({
                type: "POST",
                url: "<?php echo $this->config->item('admin_base_url') . $viewname . '/'.$formAction; ?>",
                data: $('#newsletter-form').serialize(),
                beforeSend: function () {
                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (data) {
                    window.location.href = "<?php echo $this->config->item('admin_base_url') . 'newsletter_management'; ?>";
                }
            });
            return false;
        }
    }
</script>