<?php
$facebook_url = $this->general_model->select_single('setting_master', array('value'), array('field' => 'facebook_url'), '', '=');
$google_plus_url = $this->general_model->select_single('setting_master', array('value'), array('field' => 'google_plus_url'), '', '=');
$twitter_url = $this->general_model->select_single('setting_master', array('value'), array('field' => 'twitter_url'), '', '=');
$linked_in_url = $this->general_model->select_single('setting_master', array('value'), array('field' => 'linked_in_url'), '', '=');

/* Get al product from table */
$product_list = $this->general_model->select('product_master', array('product_name'), '', '', '=', '', '', '', 'priority', 'asc');
?>
<!-- //////////////////////////////////
//////////////MAIN FOOTER//////////////
////////////////////////////////////-->
<div class="row">
<div class="col-md-12">
    <div class="owl-carousel" id="owl-carousel" data-items="8">
        <?php
        if (!empty($product_list) && count($product_list) > 0) {
            foreach ($product_list as $key => $product) {
                echo '<div>';
                echo $product['product_name'];
                echo '</div>';
            }
        }
        ?>
    </div>
</div>
</div>

</div>


<footer class="main" id="main-footer">
    <div class="footer-top-area">
        <div class="container">
            <div class="row row-wrap">
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <ul class="list list-social">
                        <li><a class="fa fa-facebook box-icon" target="_blank" href="<?php echo!empty($facebook_url['value']) ? $facebook_url['value'] : '#' ?>" data-toggle="tooltip" title="Facebook"></a></li>
                        <li><a class="fa fa-twitter box-icon" target="_blank" href="<?php echo!empty($twitter_url['value']) ? $twitter_url['value'] : '#' ?>" data-toggle="tooltip" title="Twitter"></a></li>
                        <li><a class="fa fa-google-plus box-icon" target="_blank" href="<?php echo!empty($google_plus_url['value']) ? $google_plus_url['value'] : '#' ?>" data-toggle="tooltip" title="Google Plus"></a></li>
                        <li><a class="fa fa-linkedin box-icon" target="_blank" href="<?php echo!empty($linked_in_url['value']) ? $linked_in_url['value'] : '#' ?>" data-toggle="tooltip" title="LinkedIn"></a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-12">
                    <h4>Sign Up to the Newsletter</h4>
                    <div class="box">
                        <form>
                            <div class="form-group mb5">
                                <label>E-mail</label>
                                <input type="text" class="form-control" id="newsletter_email" />
                            </div>
                            <p id="validation_error" class="hidden mb5 alert alert-danger alert-error">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </p>
                            <p id="validation_success" class="hidden mb5 alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </p>
                            <input type="button" class="btn btn-primary" onclick="newsletter_register()" value="Sign Up" />
                        </form>
                    </div>
                </div>

                <div class="col-md-3 col-sm-4 col-xs-6 text-center">
                    <ul class="list-unstyled clear-margins">
                        <li class="widget-container widget_nav_menu">
                            <h4 class="title-widget">Useful links</h4>
                            <ul>
                                <li><a  href="javascript:void(0)"><i class="fa fa-angle-double-right"></i> About Us</a></li>
                                <li><a  href="<?php echo base_url('contact'); ?>"><i class="fa fa-angle-double-right"></i> Contact Us</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- widgets column left end -->

                <div class="col-md-3 col-sm-4 col-xs-6 text-center">
                    <ul class="list-unstyled clear-margins">
                        <li class="widget-container widget_recent_news">
                            <h4 class="title-widget">Contact Detail</h4>
                            <div class="footerp">
                                <p><b>Email id:</b> <a href="mailto:info@naukari-hub.com">info@naukari-hub.com</a></p>
<!--                                <p><b>Helpline Numbers </b>
                                    <b style="color:#ffc106;">(8AM to 10PM):</b>  +91-9104730609, +91-7622094186  </p>
                                <p><b>Corp Office / Postal Address</b></p>
                                <p><b>Phone Numbers : </b>+91-9104730609, </p>-->
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer-copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <p>Copyright © 2014, Your Store, All Rights Reserved</p>
            </div>
        </div>
    </div>
</div>
</footer>
<!-- //////////////////////////////////
//////////////END MAIN  FOOTER/////////
////////////////////////////////////-->
<!-- Scripts queries -->
<script src="<?= base_url() ?>js/jquery.blockUI.js"></script>
<script src="<?= base_url() ?>js/front/owl-carousel.js"></script>
<script src="<?= base_url() ?>js/front/masonry.js"></script>
<!--<script src="<?php echo base_url() ?>js/front/nicescroll.js"></script>-->
<script src="<?php echo base_url() ?>js/front/flexnav.min.js"></script>
<script src="<?php echo base_url() ?>js/front/magnific.js"></script>
<script src="<?php echo base_url() ?>js/front/custom.js"></script>
<script src="<?php echo base_url() ?>js/front/icheck.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBaR9TIgwWIxzbcSN4S17wNE6yve8sI4Vw"></script>
<script>
                                (function () {
                                    window.onload = function () {
                                        var body = document.querySelector("body");
                                        var header = body.querySelector(".main-color");
                                        var preloader = body.querySelector(".loading-screen");
                                        var page = body.querySelector(".container");
                                        //body.style.overflowY = "auto";
                                        preloader.classList.add("loading-done");
                                        header.classList.add("loading-done");
                                        page.classList.add("loading-done");
                                    };
                                })();

                                function newsletter_register()
                                {
                                    $('#validation_error').text('');
                                    $('#validation_success').text('');
                                    var patt = new RegExp("[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$");
                                    var email = $('#newsletter_email').val();
                                    if (email != '' && typeof email != 'undefined')
                                    {
                                        if (patt.test(email) === true)
                                        {
                                            /* Check this email address all ready exits */
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo base_url() . 'newsletter/add_record'; ?>",
                                                dataType: "json",
                                                data: {'email': email},
                                                beforeSend: function ()
                                                {
                                                    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                                                },
                                                success: function (data)
                                                {
                                                    $.unblockUI();
                                                    if (data.status == 1)
                                                    {
                                                        var validation_msg = data.message;
                                                        $('#newsletter_modal .modal-body').text(validation_msg);
                                                        $('#newsletter_modal').modal('show');
                                                        $('#newsletter_email').val('');
                                                        //$('#validation_success').removeClass('hidden');
                                                    }
                                                    else
                                                    {
                                                        var validation_msg = data.message;
                                                        $('#validation_error').text(validation_msg);
                                                        $('#validation_error').removeClass('hidden');
                                                    }
                                                    return false;
                                                }
                                            });
                                        }
                                        else
                                        {
                                            var validation_msg = "<?php echo $this->lang->line('wrong_email_validation') ?>";
                                            $('#validation_error').text(validation_msg);
                                            $('#validation_error').removeClass('hidden');
                                            return false;
                                        }
                                    }
                                    else
                                    {
                                        var validation_msg = "<?php echo $this->lang->line('email_validation') ?>";
                                        $('#validation_error').text(validation_msg);
                                        $('#validation_error').removeClass('hidden');
                                        return false;
                                    }
                                }
</script>
</div>
</body>
</html>