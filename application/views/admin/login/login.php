<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $this->config->item('project_name') . ' Login' ?></title>
        
        <link rel="stylesheet" href="<?= base_url(); ?>vendors/nprogress/nprogress.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url(); ?>build/css/custom.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?= $this->config->item('css_path') ?>css.css" type="text/css">
        <link rel="stylesheet" href="<?= $this->config->item('css_path') ?>runtime.css" type="text/css">
        <link rel="stylesheet" href="<?= $this->config->item('css_path') ?>font-awesome.css" type="text/css">
        <link rel="stylesheet" href="<?= $this->config->item('css_path') ?>bootstrap.css" type="text/css">
        <link rel="stylesheet" href="<?=$this->config->item('css_path')?>App.css" type="text/css">
        <link rel="stylesheet" href="<?=$this->config->item('css_path')?>buttons.css" type="text/css">
        
        <script type="text/javascript" src="<?= $this->config->item('js_path') ?>jquery-1.9.1.js"></script>
        <script src="<?= $this->config->item('js_path') ?>jquery.blockUI.js" type="text/javascript"></script> 
        <script src="<?= $this->config->item('js_path') ?>bootstrap.js"></script> 
        <script src="<?= $this->config->item('js_path') ?>parsley.js"></script> 

        <?php
        if (isset($_COOKIE['adminsiteAuth'])) {
            $StringArray = explode('&', $_COOKIE['adminsiteAuth']);

            $usernamestring = $StringArray[0];
            $passwordstring = $StringArray[1];

            $usernamefinal = explode('=', $usernamestring);
            $username = $usernamefinal[1];

            $passwordfinal = explode('=', $passwordstring);
            $password = $passwordfinal[1];
        } else {
            $username = '';
            $password = '';
        }
        ?>
    </head>

    <body class="login">
        <div>
            <div class="login_wrapper">
                <div class="animate form login_form">
                    <section class="login_content">
                        <h3 class="text-center">
                            Welcome to <?php echo $this->config->item('project_name') ?> Admin.
                        </h3>
                        <h5 class="text-center">
                            Please sign in to get access.
                        </h5>

                        <form class="form parsley-form" id="login-form" method="post" action="" data-parsley-validate>
                            <h1 class="text-center">Login Form</h1>
                            
                            <?php
                            if (!empty($msg)) {
                                ?>
                                <div class="text-center" id="div_msg">
                                    <?php
                                    echo '<div role="alert" class="alert alert-danger alert-dismissible fade in">';
                                    echo '<button aria-label="Close" data-dismiss="alert" class="close" type="button"><span aria-hidden="true">×</span>';
                                    echo '</button>';
                                    echo "<strong>error! </strong> ".urldecode($msg)." ";
                                    echo '</div>';
                                    $newdata = array('msg' => '');
                                    $this->session->set_userdata('message_session', $newdata);
                                    ?>
                                </div>
                            <?php } ?>
                            
                            <div class="form-group">
                                <input id="email" value="<?php
                                if (isset($username)) {
                                    echo $username;
                                }
                                ?>"  placeholder="Email" autofocus type="email" name="email" class="form-control parsley-validated" data-required="true">
                            </div>

                            <div class="form-group">
                                <input id="password" value="<?php
                                if (isset($password)) {
                                    echo $password;
                                }
                                ?>"  placeholder="Password" data-bvalidator="required"  type="password" name="password" class="form-control" data-required="true">
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" id="login-btn" type="submit">Log in &nbsp; <i class="fa fa-play-circle"></i></button>
                            </div>
                            <div>
                                <a class="btn btn-default" href="javascript:;" onClick="hide_show();">Lost your password?</a>
                            </div>
                            <div class="separator">
                                <p class="change_link">New to site?
                                    <a href="#signup" class="to_register" onclick="hide_show_form('to_register')"> Create Account </a>
                                </p>
                            </div>
                        </form>
                    </section>
                </div>

                <div id="register" class="animate form registration_form hidden">
                    <section class="login_content">
                        <form>
                            <h1 class="text-center">Create Account</h1>
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="Username" required="" />
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" placeholder="Email" required="" />
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" placeholder="Password" required="" />
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" id="login-btn" type="submit">Submit<i class="fa fa-play-circle"></i></button>
                            </div>

                            <div class="clearfix"></div>

                            <div class="separator">
                                <p class="change_link">Already a member ?
                                    <a href="#signin" class="to_login" onclick="hide_show_form('to_login')"> Log in </a>
                                </p>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    function hide_show()
    {
	$('#login-container').hide(); 
        $('.forgot').show();        
    }
    function show()
    {
	$('#login-container').show();  
        $('.forgot').hide();       
    }
	
    $(document).ready(function(){
         $('#login-form').parsley();
    });
    
    function hide_show_form(txt)
    {
        if(txt == 'to_register')
        {
            $('.login_form').addClass('hidden');
            $('.registration_form').removeClass('hidden');
        }
        else
        {
            $('.login_form').removeClass('hidden');
            $('.registration_form').addClass('hidden');
        }
    }

</script>