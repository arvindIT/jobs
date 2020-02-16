<?php
$viewname = $this->router->uri->segments[2];
$formAction = 'update_data';
$path = $viewname . '/' . $formAction;
$is_edit = 'Edit';
?>
<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?php echo $this->lang->line('common_label_setting'); ?></h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form id="setting_management" method="post" action="<?= $this->config->item('admin_base_url') ?><?php echo $path ?>" data-parsley-validate class="form parsley-form form-horizontal form-label-left" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shorte_user_id"><?php echo $this->lang->line('common_label_shorte_user_id') ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="shorte_user_id" name="shorte_user_id" data-required="true" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("shorte_user_id", $editRecord) && !empty($editRecord['shorte_user_id']['value'])) {
                                        echo stripslashes($editRecord['shorte_user_id']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shorte_api_key"><?php echo $this->lang->line('common_label_shorte_api_key') ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="shorte_api_key" name="shorte_api_key" data-required="true" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("shorte_api_key", $editRecord) && !empty($editRecord['shorte_api_key']['value'])) {
                                        echo stripslashes($editRecord['shorte_api_key']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="shorte_secret_api_key"><?php echo $this->lang->line('common_label_shorte_secret_api_key') ?><span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="shorte_secret_api_key" name="shorte_secret_api_key" data-required="true" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("shorte_secret_api_key", $editRecord) && !empty($editRecord['shorte_secret_api_key']['value'])) {
                                        echo stripslashes($editRecord['shorte_secret_api_key']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="google_api_key"><?php echo $this->lang->line('common_label_google_api_key') ?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="google_api_key" name="google_api_key" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("google_api_key", $editRecord) && !empty($editRecord['google_api_key']['value'])) {
                                        echo stripslashes($editRecord['google_api_key']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="google_api_url"><?php echo $this->lang->line('common_label_google_api_url') ?>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="google_api_url" name="google_api_url" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("google_api_url", $editRecord) && !empty($editRecord['google_api_url']['value'])) {
                                        echo stripslashes($editRecord['google_api_url']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="facebook_url"><?php echo $this->lang->line('common_label_facebook_url') ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="facebook_url" name="facebook_url" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("facebook_url", $editRecord) && !empty($editRecord['facebook_url']['value'])) {
                                        echo stripslashes($editRecord['facebook_url']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="linked_in_url"><?php echo $this->lang->line('common_label_linked_in_url') ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="linked_in_url" name="linked_in_url" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("linked_in_url", $editRecord) && !empty($editRecord['linked_in_url']['value'])) {
                                        echo stripslashes($editRecord['linked_in_url']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="twitter_url"><?php echo $this->lang->line('common_label_twitter_url') ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="twitter_url" name="twitter_url" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("twitter_url", $editRecord) && !empty($editRecord['twitter_url']['value'])) {
                                        echo stripslashes($editRecord['twitter_url']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="google_plus_url"><?php echo $this->lang->line('common_label_google_plus_url') ?></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="google_plus_url" name="google_plus_url" class="form-control col-md-7 col-xs-12" value="<?php
                                    if (array_key_exists("google_plus_url", $editRecord) && !empty($editRecord['google_plus_url']['value'])) {
                                        echo stripslashes($editRecord['google_plus_url']['value']);
                                    }
                                    ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
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

<script type="text/javascript">
    function saveformdata()
    {
        if ($('#<?php echo $viewname ?>').parsley().isValid()) {
            $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
            $('#<?php echo $viewname ?>').submit();
        }
    }
</script>