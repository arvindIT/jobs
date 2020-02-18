<?php
$admin = $this->session->userdata('admin_session');
if ($this->uri->segment(2) != 'user_management') {
    $this->session->unset_userdata('user_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'user_contacts') {
    $this->session->unset_userdata('user_contacts_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'qualification_management') {
    $this->session->unset_userdata('qualification_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'jobtype_management') {
    $this->session->unset_userdata('job_type_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'jobs_management') {
    $this->session->unset_userdata('jobs_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'newsletter_management') {
    $this->session->unset_userdata('newsletter_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'setting_management') {
    $this->session->unset_userdata('setting_sortsearchpage_data');
}
if ($this->uri->segment(2) != 'product_management') {
    $this->session->unset_userdata('product_sortsearchpage_data');
}

?>
<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a href="<?php echo $this->config->item('admin_base_url'); ?>" class="site_title"><i class="fa fa-paw"></i><span>Gentelella Alela!</span></a>
        </div>
        <div class="clearfix"></div>
        <div class="profile clearfix">
            <div class="profile_pic">
                <img src="<?php echo base_url() ?>img/no_image.png" alt="..." class="img-circle profile_img">
            </div>
            <div class="profile_info">
                <span>Welcome,</span>
                <h2>John Doe</h2>
            </div>
        </div>
        <br />

        <!-- sidebar menu -->
        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                    <li>
                        <a href="<?php echo base_url('admin/user_management/') ?>"><i class="fa fa-home"></i><?= $this->lang->line('common_label_users_management'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'register') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/register') ?>"><i class="fa fa-edit"></i> <?= $this->lang->line('common_label_users_register_form'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'user_contacts') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/user_contacts') ?>"><i class="fa fa-address-book" aria-hidden="true"></i><?= $this->lang->line('common_label_users_contacts'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'qualification_management') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/qualification_management') ?>"><i class="fa fa-graduation-cap" aria-hidden="true"></i><?= $this->lang->line('common_label_qualification'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'jobtype_management') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/jobtype_management') ?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?= $this->lang->line('label_job_type_management'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'jobs_management') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/jobs_management') ?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?= $this->lang->line('label_jobs_management'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'newsletter_management') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/newsletter_management') ?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?= $this->lang->line('label_newsletter_management'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'product_management') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/product_management') ?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?= $this->lang->line('label_product_management'); ?></a>
                    </li>
                    <li <?php if ($this->uri->segment(2) == 'setting_management') { ?> class="active" <?php } ?>>
                        <a href="<?php echo base_url('admin/setting_management') ?>"><i class="fa fa-clipboard" aria-hidden="true"></i><?= $this->lang->line('label_setting_management'); ?></a>
                    </li>

                    <!--
                    <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="form.html">General Form</a></li>
                            <li><a href="form_advanced.html">Advanced Components</a></li>
                            <li><a href="form_validation.html">Form Validation</a></li>
                            <li><a href="form_wizards.html">Form Wizard</a></li>
                            <li><a href="form_upload.html">Form Upload</a></li>
                            <li><a href="form_buttons.html">Form Buttons</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-desktop"></i> UI Elements <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="general_elements.html">General Elements</a></li>
                            <li><a href="media_gallery.html">Media Gallery</a></li>
                            <li><a href="typography.html">Typography</a></li>
                            <li><a href="icons.html">Icons</a></li>
                            <li><a href="glyphicons.html">Glyphicons</a></li>
                            <li><a href="widgets.html">Widgets</a></li>
                            <li><a href="invoice.html">Invoice</a></li>
                            <li><a href="inbox.html">Inbox</a></li>
                            <li><a href="calendar.html">Calendar</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-table"></i> Tables <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="tables.html">Tables</a></li>
                            <li><a href="tables_dynamic.html">Table Dynamic</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-bar-chart-o"></i> Data Presentation <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="chartjs.html">Chart JS</a></li>
                            <li><a href="chartjs2.html">Chart JS2</a></li>
                            <li><a href="morisjs.html">Moris JS</a></li>
                            <li><a href="echarts.html">ECharts</a></li>
                            <li><a href="other_charts.html">Other Charts</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="fixed_sidebar.html">Fixed Sidebar</a></li>
                            <li><a href="fixed_footer.html">Fixed Footer</a></li>
                        </ul>
                    </li> -->
                </ul>
            </div>
            <!--
            <div class="menu_section">
                <h3>Live On</h3>
                <ul class="nav side-menu">
                    <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="e_commerce.html">E-commerce</a></li>
                            <li><a href="projects.html">Projects</a></li>
                            <li><a href="project_detail.html">Project Detail</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                            <li><a href="profile.html">Profile</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="page_403.html">403 Error</a></li>
                            <li><a href="page_404.html">404 Error</a></li>
                            <li><a href="page_500.html">500 Error</a></li>
                            <li><a href="plain_page.html">Plain Page</a></li>
                            <li><a href="login.html">Login Page</a></li>
                            <li><a href="pricing_tables.html">Pricing Tables</a></li>
                        </ul>
                    </li>
                    <li><a><i class="fa fa-sitemap"></i> Multilevel Menu <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                            <li><a href="#level1_1">Level One</a>
                            <li><a>Level One<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li class="sub_menu"><a href="level2.html">Level Two</a>
                                    </li>
                                    <li><a href="#level2_1">Level Two</a>
                                    </li>
                                    <li><a href="#level2_2">Level Two</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#level1_2">Level One</a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page <span class="label label-success pull-right">Coming Soon</span></a></li>
                </ul>
            </div> -->

        </div>
        <!-- /sidebar menu -->
    </div>
</div>
<!-- /#sidebar-wrapper -->
<script>
    function logout()
    {
        $.confirm({
            'title': 'Logout', 'message': " <strong> Are you sure want to logout?", 'buttons': {'Yes': {'class': 'special',
                    'action': function () {
                        window.location = "<?= base_url('admin/logout') ?>";
                    }}, 'No': {'class': ''}}});
    }

    function open_pdf()
    {
        window.open("<?= base_url() ?>uploads/file/BocceFest_Rules_v1.2014.pdf")
    }
</script>