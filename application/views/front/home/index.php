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
                        echo '<li id="qualification_wise" data-id="' . $categori['id'] . '"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>' . $categori['name'] . '<span class="badge">' . $categori['counter'] . '</span></a></li>';
                    }
                    echo '</ul>';
                }
                ?>
                <?php
                if (!empty($job_type)) {
                    echo '<ul class="nav nav-tabs nav-stacked nav-coupon-category nav-coupon-category-left">';
                    echo '<li id="job_type_wise" data-id="All"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>All<span>' . $total_job_type . '</span></a></li>';
                    foreach ($job_type as $key => $job) {
                        echo '<li id="job_type_wise" data-id="' . $job['id'] . '"><a href="javascript:void(0)"><i class="fa fa-ticket"></i>' . $job['name'] . '<span class="badge">' . $job['counter'] . '</span></a></li>';
                    }
                    echo '</ul>';
                }
                ?>
            </aside>
        </div>
        <div class="col-md-6 col-sm-6" id="jobs_listing">
            <?php echo $this->load->view('front/home/ajax_list'); ?>
            <div class="gap"></div>
        </div>

        <div class="col-md-3">
            <div class="col-md-12">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                          <script type="text/javascript" language="javascript">
                            var aax_size='300x250';
                            var aax_pubname = 'naukarihub-21';
                            var aax_src='302';
                          </script>
                          <script type="text/javascript" language="javascript" src="http://c.amazon-adsystem.com/aax2/assoc.js"></script>
                    </div>
                </aside>
            </div>

            <div class="col-md-12">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                          <div data-WRID="WRID-151384504485774154" data-widgetType="featuredDeals" data-responsive="yes" data-class="affiliateAdsByFlipkart" height="250" width="300"></div><script async src="//affiliate.flipkart.com/affiliate/widgets/FKAffiliateWidgets.js"></script>
                    </div>
                </aside>
            </div>

            <div class="col-md-12 mt-5">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                        <h5 class="btn btn-primary" style="width: 100%;"><?php echo $this->lang->line('common_latest_requirement_level'); ?></h5>
                        <ul class="list-group">
                        <?php
                        if(!empty($latest_requirement))
                        {
                            foreach ($latest_requirement as $key => $requirement)
                            {
                                echo '<li class="list-group-item">';
                                    echo '<label>';
                                        echo '<a href="'.base_url().'job/'.$requirement['slug'].'">'.$requirement['title']. '</a> ';
                                        echo '<span class="badge">'.$requirement['total_post'].'</span>';
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
<input type="hidden" id="searchreport" value="" />
<input type="hidden" id="perpage" value="" />
<input type="hidden" id="searchtext" value="" />
<script>
    $(document).ready(function ()
    {
        var segment = "<?php echo $this->uri->segment(1); ?>";
        if(segment != '' && typeof segment !== 'undefined')
        {
            $('html, body').animate({
                scrollTop: $("#jobs_listing").offset().top
            }, 1000);
        }

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
                    $('html, body').animate({
                       scrollTop: $("#jobs_listing").offset().top
                    }, 1000);
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
                    $('html, body').animate({
                       scrollTop: $("#jobs_listing").offset().top
                    }, 1000);
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

</script>
<!-- //////////////////////////////////
//////////////END PAGE CONTENT/////////
////////////////////////////////////-->