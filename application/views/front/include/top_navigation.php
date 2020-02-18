<!-- //////////////////////////////////
//////////////MAIN HEADER/////////////
////////////////////////////////////-->
<body>
    <div id="newsletter_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Newsletter</h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="loading-screen ">
        <div class="spinner-wrap">
            <div class="spinner"></div>
        </div>
    </div>
    <div class="global-wrap">
        <header class="main main-color">
            <div class="container">
                <div class="row">
                    <div class="col-md-2 col-xs-2 hidden-xs hidden-sm" style="margin-bottom:10px;">
                        <a href="<?php echo base_url(); ?>" class="logo">
                            <img src="<?php echo base_url(); ?>images/Naukari-hub-logo.png" alt="Logo" title="Nuakari-hub" />
                        </a>
                    </div>
                    <div class="col-md-2 col-xs-2 visible-xs visible-sm" style="margin-bottom:10px;">
                        <a href="<?php echo base_url(); ?>" class="logo">
                            <img src="<?php echo base_url(); ?>images/Naukari-hub-logo-phone.png" alt="Logo" title="Nuakari-hub" />
                        </a>
                    </div>
                    <div class="col-md-10 col-xs-10">
                        <div class="col-md-12 hidden-xs hidden-sm">
                            <div data-WRID="WRID-151436218713755216" data-widgetType="searchBar" data-class="affiliateAdsByFlipkart" height="55" width="660" ></div><script async src="//affiliate.flipkart.com/affiliate/widgets/FKAffiliateWidgets.js"></script>
                        </div>
                        <div class="col-md-12">
                            <div class="flexnav-menu-button" id="flexnav-menu-button"></div>
                            <nav>
                                <ul class="nav nav-pills flexnav flexnav-icons lg-screen" id="flexnav" data-breakpoint="800">
                                    <li>
                                        <a href="<?php echo base_url() . 'search/state-wise-jobs'; ?>"><i class="fa fa-map-marker"></i><?php echo $this->lang->line('common_menu_state_wise_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'search/railway-jobs'; ?>"><i class="fa fa-train"></i><?php echo $this->lang->line('common_menu_railway_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'search/bank-jobs'; ?>"><i class="fa fa-university"></i><?php echo $this->lang->line('common_menu_bank_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'search/defence-jobs'; ?>"><i class="fa fa-fighter-jet"></i><?php echo $this->lang->line('common_menu_defence_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'search/ssc-jobs'; ?>"><i class="fa fa-bullhorn"></i><?php echo $this->lang->line('common_menu_ssc_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'search/upsc-jobs'; ?>"><i class="fa fa-bullhorn"></i><?php echo $this->lang->line('common_menu_upsc_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'search/other-jobs'; ?>"><i class="fa fa-bullhorn"></i><?php echo $this->lang->line('common_menu_other_jobs'); ?></a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() . 'register'; ?>"><i class="fa fa-user-plus"></i><?php echo $this->lang->line('common_menu_register_jobs'); ?></a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="gap"></div>


        <!-- //////////////////////////////////
        //////////////END MAIN HEADER//////////
        ////////////////////////////////////-->