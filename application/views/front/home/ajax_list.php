<!-- //////////////////////////////////
//////////////PAGE CONTENT/////////////
////////////////////////////////////-->
<?php
if (!empty($datalist)) {
    foreach ($datalist as $key => $job_post) {
        $mode = '';
        if (!empty($job_post['is_online'])) {
            $mode .= 'Online';
        }
        if (!empty($job_post['is_offline'])) {
            $mode .= 'Offline';
        }
        ?>
        <div class="product-thumb product-thumb-horizontal">
            <div class="product-inner">
                <h4><strong><?php echo!empty($job_post['title']) ? $job_post['title'] : '' ?></strong></h4>
                <div class="product-desciption">
                    <table class="table table-striped mb0">
                        <tbody>
                            <tr>
                                <td class="col-md-3" style="font-weight: bold;"><?php echo $this->lang->line('label_post_name'); ?></td>
                                <td class="col-md-1">:</td>
                                <td class="col-md-8"><?php echo!empty($job_post['post_name']) ? ucwords($job_post['post_name']) : '' ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3" style="font-weight: bold;"><?php echo $this->lang->line('label_post_eligibility'); ?></td>
                                <td class="col-md-1">:</td>
                                <td class="col-md-8"><?php echo!empty($job_post['eligibility']) ? ucwords($job_post['eligibility']) : '' ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3" style="font-weight: bold;"><?php echo $this->lang->line('label_total_post'); ?></td>
                                <td class="col-md-1">:</td>
                                <td class="col-md-8"><?php echo!empty($job_post['total_post']) ? ucwords($job_post['total_post']) : '' ?></td>
                            </tr>
                            <tr>
                                <td class="col-md-3" style="font-weight: bold;"><?php echo $this->lang->line('label_last_date'); ?></td>
                                <td class="col-md-1">:</td>
                                <td class="col-md-8"><?php echo!empty($job_post['last_date']) ? dateformat($job_post['last_date']) . ' (' . $mode . ')' : '' ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="product-meta">
                    <span class="product-time"><i class="fa fa-clock-o"></i><?php echo ' ' . time_elapsed_string($job_post['created_date']); ?></span>
                </div>
                <ul class="product-actions-list">
                    <li>
                        <a class="btn btn-primary" href="<?php echo base_url() . 'job/' . $job_post['slug'] ?>">More Details</a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
    }
}
else
{
    echo '<div class="alert alert-danger alert-error">';
        echo '<button type="button" class="close" data-dismiss="alert">×</button>';
        echo 'No Record Found';
    echo '</div>';
    echo '<div>';
        echo '<a class="btn btn-primary flexnav-icons" href="'.base_url().'">';
        echo '<i class="fa fa-home" aria-hidden="true"></i>';
            echo 'Go Home';
        echo '</a>';
    echo '</div>';
}
?>
<?php
if (isset($this->pagination)) {
    echo $this->pagination->create_links();
}
?>
<div class="gap"></div>
<!-- //////////////////////////////////
//////////////END PAGE CONTENT/////////
////////////////////////////////////-->