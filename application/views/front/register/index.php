<!-- //////////////////////////////////
//////////////PAGE CONTENT/////////////
////////////////////////////////////-->
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <aside class="sidebar-left">
                <?php
                if (!empty($categories)) {
                    echo '<ul class="nav nav-tabs nav-stacked nav-coupon-category nav-coupon-category-left">';
                    echo '<li id="qualification_wise" data-id="All" class="active"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>All<span>' . $total_categories . '</span></a></li>';
                    foreach ($categories as $key => $categori) {
                        echo '<li id="qualification_wise" data-id="' . $categori['id'] . '"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>' . $categori['name'] . '<span>' . $categori['counter'] . '</span></a></li>';
                    }
                    echo '</ul>';
                }
                ?>
                <?php
                if (!empty($job_type)) {
                    echo '<ul class="nav nav-tabs nav-stacked nav-coupon-category nav-coupon-category-left">';
                    echo '<li id="job_type_wise" data-id="All"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>All<span>' . $total_job_type . '</span></a></li>';
                    foreach ($job_type as $key => $job) {
                        echo '<li id="job_type_wise" data-id="' . $job['id'] . '"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>' . $job['name'] . '<span>' . $job['counter'] . '</span></a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </aside>
        </div>
        <div class="col-md-6">
            <div id="register-dialog" class="mfp-with-anim mfp-dialog clearfix">
                <h3><?php echo $this->lang->line('common_register_level'); ?></h3>
                <h5><?php echo $this->lang->line('common_register_info_level'); ?></h5>
                <?php if (!empty($this->session->flashdata('success_message'))) { ?>
                    <!-- SUCCESS MESSAGE :BEGIN -->
                    <div class="alert alert-success" style="clear: both;">
                        <?php print $this->session->flashdata('success_message'); ?>
                        <button type="button" class="close fade" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- SUCCESS MESSAGE :END-->
                <?php } ?>

                <?php if (!empty($this->session->flashdata('error_message'))) { ?>
                    <!-- ERROR MESSAGE :BEGIN -->
                    <div class="alert alert-danger custom-alert" style="clear: both;" style="top: -18px; position: relative;">
                        <?php print $this->session->flashdata('error_message'); ?>
                        <button type="button" class="close fade" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <!-- ERROR MESSAGE :END-->
                <?php } ?>
                <form class="form parsley-form dialog-form" id="register_form" action="<?php echo base_url() . 'register/add_record' ?>" method="post">
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_firstname'); ?><span class="required"><?php echo $this->lang->line('common_level_required'); ?></span></label>
                        <input type="text" name="firstname" placeholder="<?php echo $this->lang->line('common_level_firstname_placeholder'); ?>" value="<?php echo set_value('firstname'); ?>" class="form-control" data-required="true">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_lastname'); ?><span class="required"><?php echo $this->lang->line('common_level_required'); ?></span></label>
                        <input type="text" name="lastname" placeholder="<?php echo $this->lang->line('common_level_lastname_placeholder'); ?>" value="<?php echo set_value('lastname'); ?>" class="form-control" data-required="true">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_whatsapp_number'); ?><span class="required"><?php echo $this->lang->line('common_level_required'); ?></span></label>
                        <input type="tel" name="number" placeholder="<?php echo $this->lang->line('common_level_whatsapp_number_placeholder'); ?>" value="<?php echo set_value('number'); ?>" class="form-control" data-required="true" onkeypress="return isNumberKey(event)" maxlength="10">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_email'); ?></label>
                        <input type="email" name="email" placeholder="<?php echo $this->lang->line('common_level_email_placeholder'); ?>" value="<?php echo set_value('email'); ?>" class="form-control" data-parsley-type="email">
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_zip'); ?></label>
                        <input type="text" name="zip_code" placeholder="" class="form-control" value="<?php echo set_value('zip_code'); ?>" onkeypress="return isNumberKey(event)" maxlength="6">
                    </div>
                    <div class="form-group">
                        <input class="i-check" type="checkbox" value="1" name="subscription" checked="checked"><?php echo $this->lang->line('common_newsletter_subscription_title'); ?>
                    </div>
                    <button type="button" onclick="saveformdata()" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <div class="col-md-3">
            <div class="col-md-12">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                        <div data-WRID="WRID-151391991718083732" data-widgetType="searchWidget" data-class="affiliateAdsByFlipkart" height="250" width="300" ></div><script async src="//affiliate.flipkart.com/affiliate/widgets/FKAffiliateWidgets.js"></script>
                    </div>
                </aside>
            </div>
            <div class="col-md-12">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                        <h5 class="btn btn-primary" style="width: 100%;"><?php echo $this->lang->line('common_latest_requirement_level'); ?></h5>
                        <ul class="list-group">
                            <?php
                            if (!empty($latest_requirement)) {
                                foreach ($latest_requirement as $key => $requirement) {
                                    echo '<li class="list-group-item">';
                                    echo '<label>';
                                    echo '<a href="' . base_url() . 'job/' . $requirement['slug'] . '">' . $requirement['title'] . '</a> ';
                                    echo '<span class="badge">' . $requirement['total_post'] . '</span>';
                                    echo '</label>';
                                    echo '</li>';
                                }
                            }
                            ?>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="searchreport" value="" />
<input type="hidden" id="perpage" value="" />
<input type="hidden" id="searchtext" value="" />
<script>
    function saveformdata()
    {
        $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
        $('#register_form').parsley().validate();
        if ($('#register_form').parsley().isValid())
        {
            $('#register_form').submit();
        }
        else
        {
            $.unblockUI();
        }
    }

    $(document).ready(function () {
        $('body').on('click', '#qualification_wise', function (e) {
            $('.sidebar-left li.active').removeClass('active');
            $(this).addClass('active');
            var url = "<?php echo base_url() . 'search/search_by_qualification' ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: $(this).data('id'),
                },
                beforeSend: function ()
                {
                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (html)
                {
                    $("#jobs_listing").html('');
                    $("#jobs_listing").html(html);
                    $('#jobs_listing').unblock();
                    $.unblockUI();
                }
            });
            return false;
        });
        $('body').on('click', '#job_type_wise', function (e) {
            $('.sidebar-left li.active').removeClass('active');
            $(this).addClass('active');
            var url = "<?php echo base_url() . 'search/search_by_job' ?>";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: $(this).data('id'),
                },
                beforeSend: function ()
                {
                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (html)
                {
                    $("#jobs_listing").html('');
                    $("#jobs_listing").html(html);
                    $('#jobs_listing').unblock();
                    $.unblockUI();
                }
            });
            return false;
        });

        $('body').on('click', '.pagination a.paginclass_A', function (e) {
            $.ajax({
                type: "POST",
                url: $(this).attr('href'),
                data: {
                    result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val()
                },
                beforeSend: function () {
                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (html) {
                    $("#jobs_listing").html('');
                    $("#jobs_listing").html(html);
                    $.unblockUI();
                }
            });
            return false;
        });
    });



    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

</script>
<!-- //////////////////////////////////
//////////////END PAGE CONTENT/////////
////////////////////////////////////-->