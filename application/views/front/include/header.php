<html lang="en">
    <head>
        <title><?php echo!empty($page_title) ? $page_title : $this->lang->line('common_home_page_title'); ?></title>
        <!-- meta info -->
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta name="keywords" content="Latest Govt Jobs, Railway Jobs, SSC Jobs, PSC Jobs, Bank Jobs, Police Jobs , Engineering Jobs, Professional Jobs, Teaching Jobs etc." />
        <meta name="description" content="Latest Govt Jobs, Railway Jobs, SSC Jobs, PSC Jobs, Bank Jobs, Police Jobs , Engineering Jobs, Professional Jobs, Teaching Jobs etc.">
        <meta name="author" content="Tsoy">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Google fonts -->
		<link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/images/favicon.ico"/>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700,300' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Roboto:400,100,300' rel='stylesheet' type='text/css'>
        <!-- Bootstrap styles -->
        <link rel="stylesheet" href="<?= base_url() ?>css/front/boostrap.css">
        <!-- Font Awesome styles (icons) -->
        <link rel="stylesheet" href="<?= base_url() ?>css/front/css/font-awesome.css">
        <!-- Main Template styles -->
        <link rel="stylesheet" href="<?= base_url() ?>css/front/styles.css">
        <!-- IE 8 Fallback -->
        <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="css/ie.css" />
    <![endif]-->
        <!-- Your custom styles (blank file) -->
        <link rel="stylesheet" href="<?= base_url() ?>css/front/mystyles.css">

        <script src="<?php echo base_url() ?>vendors/jquery/dist/jquery.min.js"></script>
        <script src="<?= base_url() ?>js/front/boostrap.min.js"></script>
        <script src="<?php echo $this->config->item('js_path') ?>parsley.js"></script>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({
                google_ad_client: "ca-pub-3063481340388998",
                enable_page_level_ads: true
            });
        </script>
    </head>
    <?php print $this->load->view('front/include/top_navigation'); ?>