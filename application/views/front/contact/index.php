<!-- //////////////////////////////////
//////////////PAGE CONTENT/////////////
////////////////////////////////////-->
<div class="container">
    <div class="row row-wrap">
        <div class="col-md-6">
            <div id="map-canvas" style="width:100%; height:300px;"></div>
        </div>
        <div class="col-md-3">
            <form name="contactForm" id="contact-form" class="contact-form" method="post" action="<?php echo base_url('contact/send_message') ?>">
                <fieldset>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_name'); ?></label>
                        <input class="form-control" id="name" name="name" type="text" data-required="required" placeholder="<?php echo $this->lang->line('common_level_name_placeholder'); ?>" />
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_email'); ?></label>
                        <input class="form-control" id="email" name="email" data-parsley-type="email" type="email" data-required="required" placeholder="<?php echo $this->lang->line('common_level_email_placeholder'); ?>" />
                    </div>
                    <div class="form-group">
                        <label><?php echo $this->lang->line('common_level_message'); ?></label>
                        <textarea class="form-control" id="message" name="message" data-required="required" placeholder="<?php echo $this->lang->line('common_level_message_placeholder'); ?>"></textarea>
                    </div>
                    <div class="bg-warning alert-success form-alert" id="form-success">Your message has been sent successfully!</div>
                    <button id="send-message" type="button" onclick="return setdefaultdata();"  class="btn btn-primary">Send Message</button>
                </fieldset>
            </form>
        </div>
        <div class="col-md-3">
            <h5><strong><?php echo $this->lang->line('common_level_contact_info'); ?></strong></h5>
            <ul class="list">
                <li><i class="icon-phone"></i><strong><?php echo $this->lang->line('common_level_phone'); ?>: </strong> <?php echo $this->lang->line('common_level_phone_data'); ?></li>
                <li><i class="icon-envelope"></i><strong><?php echo $this->lang->line('common_level_email_info'); ?>: </strong> <a href="<?php echo $this->lang->line('common_level_email_info_data'); ?>"><?php echo $this->lang->line('common_level_email_info_data'); ?></a></li>
            </ul>
        </div>
    </div>
    <div class="gap gap-small"></div>
</div>
<script>
    function setdefaultdata()
    {
        $('#contact-form').parsley().validate();
        if ($('#contact-form').parsley().isValid())
        {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url().'contact/send_message'; ?>",
                data: $('#contact-form').serialize(),
                dataType:"json",
                beforeSend: function () {
                    //$.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
                },
                success: function (data)
                {
                    if(data.status == 1)
                    {
                        $('#name').val('');
                        $('#email').val('');
                        $('#message').val('');

                        $('.alert-success').text('');
                        $('.alert-success').text(data.message);
                        $('.alert-success').css("display","block");
                        setTimeout(function(){
                            $('.alert-success').css("display","none");
                        }, 3000);
                    }
                    return false;
                }
            });
            return false;
        }
    }
</script>
