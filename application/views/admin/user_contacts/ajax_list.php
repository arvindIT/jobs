<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
$viewname = $this->router->uri->segments[2];
$admin_session = $this->session->userdata('jow_admin_session');
if (isset($sortby) && $sortby == 'asc') {
    $sorttypepass = 'desc';
} else {
    $sorttypepass = 'asc';
}
?>
<div class="col-md-12 col-sm-12 col-xs-12 text-center"></div>
<div class="clearfix"></div>
<?php
if (!empty($datalist) && count($datalist) > 0) {
    foreach ($datalist as $key => $list) {
        $pic = !empty($list['pic']) ? $this->config->item('user_pic_small_img_url') . $list['pic'] : base_url('img/no_image.png');
        ?>
        <div class="col-md-4 col-sm-4 col-xs-12 profile_details">
            <div class="well profile_view">
                <div class="col-sm-12">
                    <div class="left col-xs-8">
                        <h2><?php echo ucfirst($list['first_name']) . ' ' . ucfirst($list['last_name']); ?></h2>
                        <p><strong>About: </strong> <?= $list['highest_qualification']; ?> </p>
                        <ul class="list-unstyled">
                            <li><i class="fa fa-phone"></i> Phone: <?php echo $list['contact_no'] ?> </li>
                            <li><i class="fa fa-transgender"></i> Gender: <?php echo ($list['gender'] == 1) ? 'Male' : 'Female' ?></li>
                            <li><i class="fa fa-birthday-cake"></i> DOB: <?php echo ($list['dob'] != '0000-00-00') ? date('d-m-Y', strtotime($list['dob'])) : '' ?></li>
                            <li><i class="fa fa-envelope"></i> Email: <?php echo $list['email'] ?></li>
                            <li><i class="fa fa-map-marker"></i> Location: <?php echo $list['location'] ?></li>
                        </ul>
                    </div>
                    <div class="right col-xs-4 text-center">
                        <img src="<?php echo $pic ?>" alt="" class="img-circle img-responsive">
                    </div>
                </div>
                <div class="col-xs-12 bottom text-center">
                    <div class="col-xs-12 col-sm-6 emphasis"></div>
                    <div class="col-xs-12 col-sm-6 emphasis"></div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    No Record Found
<?php }
?>
<div class="clearfix"></div>
<div class="row dt-rb">
    <div class="col-sm-6"> </div>
    <div class="col-sm-6">
        <div class="dataTables_paginate paging_bootstrap float-right" id="common_tb">
            <?php
            if (isset($pagination)) {
                echo $pagination;
            }
            ?>
        </div>
    </div>
</div>