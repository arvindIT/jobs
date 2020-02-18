<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dashboard - Admin</title>
        <link href="<?php echo base_url() ?>vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= $this->config->item('css_path') ?>App.css" type="text/css">
        <link rel="stylesheet" href="<?= $this->config->item('css_path') ?>buttons.css" type="text/css">
        <link href="<?php echo base_url() ?>vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/animate.css/animate.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/select2/dist/css/select2.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/switchery/dist/switchery.min.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/starrr/dist/starrr.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
        <link href="<?php echo base_url() ?>vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
        <link href="<?php echo $this->config->item('css_path') ?>jquery.confirm.css" rel="stylesheet" />
        <link href="<?php echo base_url() ?>build/css/custom.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/multiselect/jquery.multiselect.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/multiselect/jquery.multiselect.filter.css">
        <link rel="stylesheet" href="<?php echo base_url() ?>css/multiselect/jquery-ui.css">
        <!-- iCheck -->
        <link href="<?php echo base_url() ?>vendors/iCheck/skins/flat/green.css" rel="stylesheet">
        <!-- bootstrap-wysiwyg -->
        <script src="<?php echo base_url() ?>vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?php echo $this->config->item('js_path') ?>jquery.blockUI.js" type="text/javascript"></script>
        <script src="<?php echo $this->config->item('js_path') ?>parsley.js"></script>
        <script src="<?php echo $this->config->item('js_path') ?>jquery.confirm.js"></script>
        <script src="<?php echo base_url() ?>vendors/ckeditor/ckeditor.js"></script>
    </head>
    <body class="nav-sm">
        <div class="container body">
            <div class="main_container">
                <?php echo $this->load->view('admin/include/left') ?>
                <?php
                echo $this->load->view('admin/include/top_navigation')?>