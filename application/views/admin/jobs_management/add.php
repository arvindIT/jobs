<?php
//pr($editRecord);exit;
//echo date("d-M-Y", strtotime($editRecord[0]['last_date'])); exit;
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
                        <h2><?php echo $this->lang->line('common_label_job_form'); ?></h2>
                        <ul class="nav navbar-right panel_toolbox"></ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="wizard" class="form_wizard wizard_horizontal">
                            <ul class="wizard_steps">
                                <li>
                                    <a href="#step-1">
                                        <span class="step_no">1</span>
                                        <span class="step_descr">Step 1
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step-2">
                                        <span class="step_no">2</span>
                                        <span class="step_descr">Step 2
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#step-3">
                                        <span class="step_no">3</span>
                                        <span class="step_descr">Step 3
                                        </span>
                                    </a>
                                </li>
                            </ul>
                            <form class="form parsley-form form-horizontal form-label-left" id="job-form" enctype="multipart/form-data" action="<?php echo $this->config->item('admin_base_url') . $viewname . '/' . $formAction; ?>" method="post">

                                <div id="step-1">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="job_title">
                                            <?php echo $this->lang->line('common_label_job_title'); ?> <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="job_title" data-required="true" name="job_title" class="form-control col-md-7 col-xs-12" value="<?php echo!empty($editRecord[0]['title']) ? $editRecord[0]['title'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="job_post">
                                            <?php echo $this->lang->line('common_label_job_post'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="job_post" name="job_post" data-required="true" class="form-control col-md-7 col-xs-12" value="<?php echo!empty($editRecord[0]['post_name']) ? $editRecord[0]['post_name'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="job_post">
                                            <?php echo $this->lang->line('common_label_job_post_slug'); ?>
                                            <span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="job_slug" name="job_slug" data-required="true" class="form-control col-md-7 col-xs-12" value="<?php echo!empty($editRecord[0]['slug']) ? $editRecord[0]['slug'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_board" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_post_no'); ?><span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="job_post_no" data-required="true" class="form-control col-md-7 col-xs-12" type="text" name="job_post_no" value="<?php echo!empty($editRecord[0]['total_post']) ? $editRecord[0]['total_post'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_board" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_board'); ?><span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="job_board" data-required="true" class="form-control col-md-7 col-xs-12" type="text" name="job_board" value="<?php echo!empty($editRecord[0]['board_name']) ? $editRecord[0]['board_name'] : '' ?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_eligibility" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_eligibility'); ?><span class="required">*</span></label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="job_eligibility" class="form-control col-md-7 col-xs-12" data-required="true" type="text" name="job_eligibility" value="<?php echo!empty($editRecord[0]['eligibility']) ? $editRecord[0]['eligibility'] : '' ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_last_date'); ?><span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input id="last_date" name="last_date" class="date-picker form-control col-md-7 col-xs-12" data-required="true" type="text" value="<?php echo!empty($editRecord[0]['last_date']) ? date("d-M-Y", strtotime($editRecord[0]['last_date'])) : date('d-M-Y'); ?>">
                                        </div>
                                    </div>
                                    <?php
                                    $is_online = 'checked';
                                    if (!empty($editRecord)) {
                                        if (empty($editRecord[0]['is_online'])) {
                                            $is_online = '';
                                        }
                                    }
                                    $is_offline = '';
                                    if (!empty($editRecord)) {
                                        if (!empty($editRecord[0]['is_offline'])) {
                                            $is_offline = '';
                                        }
                                    }
                                    ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_mode'); ?><span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12 checkbox">
                                            <input type="checkbox" name="is_online" value="1" class="flat" <?php echo $is_online; ?>> Online
                                            <input type="checkbox" name="is_offline" value="0" class="flat" <?php echo $is_offline; ?>> Offline
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_qualification_type'); ?><span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select1_single form-control" tabindex="-1" name="qualification_type[]" data-required="true" multiple="multiple" id="qualification_type">
                                                <?php
                                                if (!empty($qualification_type)) {
                                                    $qualification_id = !empty($editRecord[0]['qualification_id']) ? explode(",", $editRecord[0]['qualification_id']) : '';
                                                    foreach ($qualification_type as $key => $type) {
                                                        $select = '';
                                                        if (!empty($qualification_id) && in_array($type['id'], $qualification_id)) {
                                                            $select = 'selected = "selected"';
                                                        }
                                                        echo '<option value="' . $type['id'] . '" ' . $select . '>' . ucwords($type['name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_type'); ?><span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <select class="select2_single form-control" tabindex="-1" name="job_type[]" data-required="true" id="job_type" multiple="multiple">
                                                <?php
                                                if (!empty($job_type)) {
                                                    $job_id = !empty($editRecord[0]['type_id']) ? explode(",", $editRecord[0]['type_id']) : '';
                                                    foreach ($job_type as $key => $type) {
                                                        $selected = '';
                                                        if (!empty($job_id) && in_array($type['id'], $job_id)) {
                                                            $selected = 'selected = "selected"';
                                                        }
                                                        echo '<option value="' . $type['id'] . '" ' . $selected . '>' . ucwords($type['name']) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-2">
                                    <div class="form-group">
                                        <label for="job_of_detail" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_of_detail'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_of_detail" name="job_of_detail" ><?php echo!empty($editRecord[0]['detail_of_post']) ? $editRecord[0]['detail_of_post'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_of_education" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_education'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_of_education" name="job_of_education" ><?php echo!empty($editRecord[0]['qualification']) ? $editRecord[0]['qualification'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_age_criteria" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_age_criteria'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_age_criteria" name="job_age_criteria" ><?php echo!empty($editRecord[0]['age_criteria']) ? $editRecord[0]['age_criteria'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_selection_mode" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_selection_mode'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_selection_mode" name="job_selection_mode"><?php echo!empty($editRecord[0]['selection_mode']) ? $editRecord[0]['selection_mode'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_payable_fee" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_payable_fee'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_payable_fee" name="job_payable_fee" ><?php echo!empty($editRecord[0]['payable_fee']) ? $editRecord[0]['payable_fee'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="job_scale_of_pay" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_job_scale_of_pay'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_scale_of_pay" name="job_scale_of_pay"><?php echo!empty($editRecord[0]['scale_of_pay']) ? $editRecord[0]['scale_of_pay'] : '' ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div id="step-3">
                                    <div class="form-group">
                                        <label for="job_apply" class="control-label col-md-3 col-sm-3 col-xs-12">
                                            <?php echo $this->lang->line('common_label_apply'); ?><span class="required">*</span></label>
                                        <div class="col-md-7 col-sm-7 col-xs-12">
                                            <textarea class="ckeditor" id="job_apply" name="job_apply" required="required"><?php echo!empty($editRecord[0]['how_to_apply']) ? $editRecord[0]['how_to_apply'] : '' ?></textarea>
                                        </div>
                                    </div>
                                    <?php if(!empty($important_link)) {
                                        $i = 1;
                                         foreach ($important_link as $key => $link)
                                         { ?>
                                            <div class="form-group important_link_section" id="important_link_section_<?php echo $i; ?>">
                                                <label for="important_link" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                    <?php echo $this->lang->line('common_label_important_link'); ?><span class="required">*</span></label>
                                                <div class="col-md-7 col-sm-7 col-xs-12">
                                                    <div class="col-md-5 col-sm-5 col-xs-12">
                                                        <input type="text" id="label" name="label[]" class="form-control col-md-7 col-xs-12" value="<?php echo!empty($link['label']) ? $link['label'] : '' ?>">
                                                    </div>

                                                    <div class="col-md-4 col-sm-4 col-xs-12 <?php echo !empty($link['advertisement_link'])?'' : 'hidden' ?>" id="important_link_<?php echo $i; ?>">
                                                        <input type="text" id="important_link" name="important_link[]" class="form-control col-md-7 col-xs-12" value="<?php echo!empty($link['advertisement_link']) ? $link['advertisement_link'] : '' ?>">
                                                    </div>

                                                    <div class="col-md-4 col-sm-4 col-xs-12 <?php echo !empty($link['uploaded_file'])?'' : 'hidden' ?>" id="upload_file_<?php echo $i; ?>">
                                                        <input type="file" name="upload_file[]" value="">
                                                        <div class="upload-note"><?php echo !empty($link['uploaded_file']) ? $link['uploaded_file'] : '' ?></div>
                                                    </div>

                                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                                        <button type="button" class="btn btn-success btn-xs upload_file_button" data-rel="<?php echo $i; ?>" id="upload_file_button_<?php echo $i; ?>"><?php echo !empty($link['advertisement_link']) ? 'Upload' : 'Add Link' ?></button>
                                                    </div>
                                                    <?php
                                                    if($i == 1) { ?>
                                                        <div class="col-md-1 col-sm-1 col-xs-12">
                                                            <i class="fa fa-plus-circle fa-2x" aria-hidden="true" id="add_important_link"></i>
                                                        </div>
                                                    <?php } else { ?>
                                                            <div class="col-md-1 col-sm-1 col-xs-12">
                                                                <i class="fa fa-minus-circle fa-2x" aria-hidden="true" id="remove_important_link" data-id="<?php echo !empty($link['id']) ? $link['id'] : '' ?>" rel="<?php echo $i; ?>"></i>
                                                            </div>
                                                    <?php } ?>

                                                </div>
                                            </div>
                                     <?php $i++; } ?>

                                    <?php } else { ?>
                                        <div class="form-group important_link_section" id="important_link_section_1">
                                            <label for="important_link" class="control-label col-md-3 col-sm-3 col-xs-12">
                                                <?php echo $this->lang->line('common_label_important_link'); ?><span class="required">*</span></label>
                                            <div class="col-md-7 col-sm-7 col-xs-12">
                                                <div class="col-md-5 col-sm-5 col-xs-12">
                                                    <input type="text" id="label" name="label[]" class="form-control col-md-7 col-xs-12" value="">
                                                </div>
                                                <div class="col-md-4 col-sm-4 col-xs-12" id="important_link_1">
                                                    <input type="text" id="important_link" name="important_link[]" class="form-control col-md-7 col-xs-12">
                                                </div>

                                                <div class="col-md-4 col-sm-4 col-xs-12 hidden" id="upload_file_1">
                                                    <input type="file" name="upload_file[]" value="">
                                                </div>

                                                <div class="col-md-2 col-sm-2 col-xs-12">
                                                    <button type="button" class="btn btn-success btn-xs upload_file_button" data-rel="1" id="upload_file_button_1">Upload</button>
                                                </div>
                                                <div class="col-md-1 col-sm-2 col-xs-12">
                                                    <i class="fa fa-plus-circle fa-2x" aria-hidden="true" id="add_important_link"></i>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <input type="hidden" name="id" value="<?php echo!empty($editRecord[0]['id']) ? $editRecord[0]['id'] : '' ?>""
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
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('job_of_detail');
    CKEDITOR.replace('job_of_education');
    CKEDITOR.replace('job_age_criteria');
    CKEDITOR.replace('job_payable_fee');
    CKEDITOR.replace('job_apply');
    CKEDITOR.replace('job_selection_mode');
    CKEDITOR.replace('job_scale_of_pay');

    /*
     CKEDITOR.replace( 'job_of_detail', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     CKEDITOR.replace( 'job_of_education', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     CKEDITOR.replace( 'job_age_criteria', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     CKEDITOR.replace( 'job_payable_fee', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     CKEDITOR.replace( 'job_scale_of_pay', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     CKEDITOR.replace( 'job_apply', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     CKEDITOR.replace( 'job_selection_mode', {
     // Define the toolbar groups as it is a more accessible solution.
     toolbarGroups: [
     {"name":"basicstyles","groups":["basicstyles"]},
     {"name":"links","groups":["links"]},
     {"name":"paragraph","groups":["list","blocks"]},
     {"name":"document","groups":["mode"]},
     {"name":"insert","groups":["insert"]},
     {"name":"styles","groups":["styles"]},
     {"name":"about","groups":["about"]}
     ],
     // Remove the redundant buttons from toolbar groups defined above.
     removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
     } );
     */
</script>
<script>
    var next_count = 1;
    $(document).ready(function ()
    {
        $('#last_date').datetimepicker({
            format: 'DD-MMM-YYYY'
        });

        $('#job_post').on('keyup', function () {
            var Text = $(this).val();
            $("#job_slug").val(convertToSlug(Text));
        });

        $('#qualification_type').multiselect();
        $('#job_type').multiselect();

        $(document).on('click', '#remove_important_link', function(){
            var remove_count = $(this).attr('rel');
            var id = $(this).data('id');
            if(id != '' && typeof id != 'undefined')
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('admin_base_url') . $viewname . '/linkdelete'; ?>",
                    data: {'id' : id},
                    beforeSend: function () {
                        $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                    },
                    success: function (data) {
                        $('#important_link_section_'+remove_count).remove();
                        $.unblockUI();
                    }
                });
            }
            else
            {
                $('#important_link_section_'+remove_count).remove();
            }
        });

        $(document).on('click', '.upload_file_button', function()
        {
            var text = $(this).text();
            var count = $(this).data('rel');
            if(text == "Add Link")
            {
                $('#important_link_'+count).removeClass('hidden');
                $('#upload_file_'+count).addClass('hidden');
                $('#upload_file_button_'+count).text('').text('Upload');
            }
            else
            {
                $('#important_link_'+count).addClass('hidden');
                $('#upload_file_'+count).removeClass('hidden');
                $('#upload_file_button_'+count).text('').text('Add Link');
            }
        });

        $('#add_important_link').on('click', function(){
            var count = $('.important_link_section').length;
            next_count = next_count + 1;
            //alert(count);
            var HTML = '';
            HTML += '<div class="form-group important_link_section" id="important_link_section_'+next_count+'">';
                HTML += '<label for="important_link" class="control-label col-md-3 col-sm-3 col-xs-12">';
                HTML += '</label>';

                HTML += '<div class="col-md-7 col-sm-7 col-xs-12">';
                    HTML += '<div class="col-md-5 col-sm-5 col-xs-12">';
                        HTML += '<input type="text" id="label" name="label[]" class="form-control col-md-7 col-xs-12" value="">';
                    HTML += '</div>';

                    HTML += '<div class="col-md-4 col-sm-4 col-xs-12" id="important_link_'+next_count+'">';
                        HTML += '<input type="text" id="important_link" name="important_link[]" class="form-control col-md-7 col-xs-12" value="">';
                    HTML += '</div>';

                    HTML += '<div class="col-md-4 col-sm-4 col-xs-12 hidden" id="upload_file_'+next_count+'">';
                         HTML += '<input type="file" name="upload_file[]">';
                    HTML += '</div>';

                    HTML += '<div class="col-md-2 col-sm-2 col-xs-12">';
                        HTML += '<button type="button" class="btn btn-success btn-xs upload_file_button" data-rel="'+next_count+'" id="upload_file_button_'+next_count+'">Upload</button>';
                    HTML += '</div>';

                    HTML += '<div class="col-md-1 col-sm-1 col-xs-12">';
                        HTML += '<i class="fa fa-minus-circle fa-2x" aria-hidden="true" id="remove_important_link" rel="'+next_count+'"></i>';
                    HTML += '</div>';
                HTML += '</div>';
            HTML += '</div>';
            $( "#step-3" ).append(HTML);
            //$(HTML).insertAfter( "#important_link_section_"+count);
        });
    });

    function convertToSlug(Text)
    {
        return Text
                .toLowerCase()
                .replace(/ /g, '-')
                .replace(/[^\w-]+/g, '')
                ;
    }

    function saveformdata()
    {
        $('#job-form').parsley().validate();
        if ($('#job-form').parsley().isValid())
        {
            updateAllMessageForms();
            $('#job-form').submit();
        }
    }

    function updateAllMessageForms()
    {
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
    }
</script>