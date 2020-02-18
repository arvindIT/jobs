<?php
$viewname = $this->router->uri->segments[2];
$formAction = !empty($editRecord) ? 'update_data' : 'insert_data';
$path = $viewname . '/' . $formAction;
$head_title = !empty($editRecord) ? 'Edit Product' : 'Add New Product';
?>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2><?= $head_title ?></h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <form class="form parsley-form form-horizontal form-label-left" enctype="multipart/form-data" name="<?php echo $viewname; ?>" id="<?php echo $viewname; ?>" method="post" accept-charset="utf-8" action="<?= $this->config->item('admin_base_url') ?><?php echo $path ?>" >
                            <div class="form-group">
                                <label for="select-multi-input"><?php echo $this->lang->line('common_label_product_title'); ?><span style="color:#F00">*</span></label>
                                <textarea id="product_name" class="form-control parsley-validated" name="product_name" data-required="true"><?= !empty($editRecord[0]['product_name']) ? $editRecord[0]['product_name'] : ''; ?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="select-multi-input"><?php echo $this->lang->line('common_label_priority'); ?><span style="color:#F00">*</span></label>
                                <input id="priority" name="priority" class="form-control parsley-validated" type="text" placeholder="Priority" data-required="required" value="<?= !empty($editRecord[0]['priority']) ? $editRecord[0]['priority'] : ''; ?>" data-required="true">
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="<?= !empty($editRecord[0]['id']) ? $editRecord[0]['id'] : ''; ?>" />
                                <button type="submit" onclick="return setdefaultdata();" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function setdefaultdata()
    {
        if ($('#<?php echo $viewname ?>').parsley().isValid()) {
            $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
        }
    }
</script>