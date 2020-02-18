<!-- //////////////////////////////////
//////////////PAGE CONTENT/////////////
////////////////////////////////////-->
<?php
$mode = '';
if (!empty($record['is_online'])) {
    $mode .= 'Online';
}
if (!empty($record['is_offline'])) {
    $mode .= 'Offline';
}
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <article class="post">
                <div class="post-inner">
                    <h3 class="post-title"><strong><?php echo!empty($record['title']) ? $record['title'] : '' ?></strong></h3>
                    <ul class="post-meta">
                        <li><i class="fa fa-calendar"></i><strong><?php echo ' ' . date("j F Y", strtotime($record['created_date'])); ?></strong>
                        </li>
                        <li><i class="fa fa-clock-o"></i><strong><?php echo ' ' . time_elapsed_string($record['created_date']); ?></strong>
                        </li>
                    </ul>
                    <div class="gap gap-mini"></div>
                    <p><strong><?php echo!empty($record['title']) ? $record['title'] : '' ?></strong> Has Released For <strong><?php echo!empty($record['total_post']) ? $record['total_post'] : '' ?> <?php echo!empty($record['post_name']) ? $record['post_name'] : '' ?></strong> Posts.</p>
                    <p>All Candidates Can Apply <strong><?php echo!empty($mode) ? $mode : '' ?></strong> On Or Before <strong><?php echo!empty($record['last_date']) ? dateformat($record['last_date']) : '' ?></strong>.</p>
                    <p class="post-meta">For more information related to <strong>Educational Qualification, Age Criteria, Selection Mode, Important Date and other Eligibility process </strong> please read the below article carefully. Also must read the official advertisement in detail before applying.</p>
                    <?php if (!empty($record['total_post']) && !empty($record['last_date'])) { ?>
                        <div class="gap gap-mini"></div>
                        <table class="table table-striped mb0">
                            <tbody>
                                <tr>
                                    <td class="col-md-3"><strong>Total Post</strong> </td>
                                    <td class="col-md-1">:</td>
                                    <td class="col-md-8"><?php echo!empty($record['total_post']) ? $record['total_post'] : '' ?></td>
                                </tr>
                                <tr>
                                    <td class="col-md-3"><strong>Last Date</strong></td>
                                    <td class="col-md-1">:</td>
                                    <td class="col-md-8"><?php echo!empty($record['last_date']) ? dateformat($record['last_date']) . '<strong> (' . $mode . ')</strong>' : '' ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php } ?>
                    <?php if (!empty($record['detail_of_post'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>Detail of Posts  - </strong><?php echo!empty($record['detail_of_post']) ? $record['detail_of_post'] : '' ?></p>
                    <?php } ?>
                    <?php if (!empty($record['qualification'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>Educational Qualification - </strong><?php echo!empty($record['qualification']) ? $record['qualification'] : '' ?></p>
                    <?php } ?>
                    <?php if (!empty($record['age_criteria'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>Age Criteria - </strong><?php echo!empty($record['age_criteria']) ? $record['age_criteria'] : '' ?></p>
                    <?php } ?>
                    <?php if (!empty($record['payable_fee'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>Payable Fee - </strong><?php echo!empty($record['payable_fee']) ? $record['payable_fee'] : '' ?></p>
                    <?php } ?>
                    <?php if (!empty($record['scale_of_pay'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>Scale Of Pay - </strong><?php echo!empty($record['scale_of_pay']) ? $record['scale_of_pay'] : '' ?></p>
                    <?php } ?>
                    <?php if (!empty($record['selection_mode'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>Selection Mode - </strong><?php echo!empty($record['selection_mode']) ? $record['selection_mode'] : '' ?></p>
                    <?php } ?>
                    <?php if (!empty($record['how_to_apply'])) { ?>
                        <div class="gap gap-mini"></div>
                        <p> <strong>How To Apply - </strong><?php echo!empty($record['how_to_apply']) ? $record['how_to_apply'] : '' ?></p>
                    <?php } ?>
                    <div class="gap gap-mini"></div>
                    <?php
                    if (!empty($record['important_link'])) {
                        echo '<table class="table table-striped mb0">';
                        echo '<tbody>';
                        foreach ($record['important_link'] as $key => $value) {
                            ?>
                            <tr>
                                <td class="col-md-4"><strong><?php echo!empty($value['label']) ? $value['label'] : 'Advertisement Link' ?></strong> </td>
                                <td class="col-md-1"> : </td>
                                <td class="col-md-7" id="important_link" data-url="<?php echo $record['short_url'] ?>"><?php echo!empty($value['advertisement_link']) ? '<a href="' . $value['advertisement_link'] . '" target=_blank">' . $value['advertisement_link'] . '</a>' : '' ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                        </table>
                    <?php } ?>
                </div>
            </article>
        </div>
        <div class="col-md-3">
            <!-- Only for table view  -->
            <div class="visible-sm">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                        <script type="text/javascript" language="javascript">
                            var aax_size = '728x90';
                            var aax_pubname = 'naukarihub-21';
                            var aax_src = '302';
                        </script>
                        <script type="text/javascript" language="javascript" src="http://c.amazon-adsystem.com/aax2/assoc.js"></script>
                    </div>
                </aside>
            </div>

            <div class="col-md-12 hidden-sm">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                        <div data-WRID="WRID-151391991718083732" data-widgetType="searchWidget" data-class="affiliateAdsByFlipkart" height="250" width="300" ></div><script async src="//affiliate.flipkart.com/affiliate/widgets/FKAffiliateWidgets.js"></script>
                    </div>
                </aside>
            </div>
            <div class="col-md-12 hidden-sm">
                <aside class="sidebar-left">
                    <div class="sidebar-box">
                        <script type="text/javascript" language="javascript">
                            var aax_size = '300x600';
                            var aax_pubname = 'naukarihub-21';
                            var aax_src = '302';
                        </script>
                        <script type="text/javascript" language="javascript" src="http://c.amazon-adsystem.com/aax2/assoc.js"></script>
                    </div>
                </aside>
            </div>
            <div class="col-md-12">
                <h5 class="btn btn-primary" style="width: 100%;"><?php echo $this->lang->line('common_latest_requirement_level'); ?></h5>
                <ul class="list-group">
                    <?php
                    if (!empty($latest_requirement)) {
                        foreach ($latest_requirement as $key => $requirement) {
                            echo '<li class="list-group-item">';
                            echo '<label>';
                            echo '<a href="' . base_url() . 'job/' . $requirement['slug'] . '">' . $requirement['title'] . '</a> ';
                            echo '<span class="badge">' . $requirement['total_post'] . '</span>';
                            echo '</label>';
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>