<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<?php
$viewname = $this->router->uri->segments[2];
$admin_session = $this->session->userdata('jow_admin_session');
?>
<?php
if (isset($sortby) && $sortby == 'asc') {
    $sorttypepass = 'desc';
} else {
    $sorttypepass = 'asc';
}
?>

<table id="datatable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th class="sorting_disabled text-center" role="columnheader" rowspan="1" colspan="1" aria-label="">
                <div class="">
                    <input type="checkbox" class="selecctall" id="selecctall">
                </div>
            </th>
            <th data-direction="desc" data-sortable="true" data-filterable="true" <?php
                if (isset($sortfield) && $sortfield == 'user_name')
                {
                    if ($sortby == 'asc') {
                        echo "class = 'sorting_desc'";
                    } else {
                        echo "class = 'sorting_asc'";
                    }
                }
                ?> role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Rendering engine: activate to sort column ascending"><a href="javascript:void(0);" onclick="applysortfilte_contact('user_name', '<?php echo $sorttypepass; ?>')">
                <?php echo $this->lang->line('common_label_user_name') ?>
                </a>
            </th>
            <th data-direction="desc" data-sortable="true" data-filterable="true" <?php
                if (isset($sortfield) && $sortfield == 'contact_no') {
                    if ($sortby == 'asc') {
                        echo "class = 'sorting_desc'";
                    } else {
                        echo "class = 'sorting_asc'";
                    }
                }
                ?> role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Rendering engine: activate to sort column ascending"><a href="javascript:void(0);" onclick="applysortfilte_contact('contact_no', '<?php echo $sorttypepass; ?>')">
                <?php echo $this->lang->line('common_label_mobile') ?>
                </a>
            </th>
            <th data-direction="desc" data-sortable="true" data-filterable="true" <?php
                if (isset($sortfield) && $sortfield == 'gender') {
                    if ($sortby == 'asc') {
                        echo "class = 'sorting_desc'";
                    } else {
                        echo "class = 'sorting_asc'";
                    }
                }
                ?> role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Rendering engine: activate to sort column ascending"><a href="javascript:void(0);" onclick="applysortfilte_contact('gender', '<?php echo $sorttypepass; ?>')">
                <?php echo $this->lang->line('common_label_gender') ?>
                </a>
            </th>
            <th data-direction="desc" data-sortable="true" data-filterable="true" <?php
                if (isset($sortfield) && $sortfield == 'highest_qualification') {
                    if ($sortby == 'asc') {
                        echo "class = 'sorting_desc'";
                    } else {
                        echo "class = 'sorting_asc'";
                    }
                }
                ?> role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Rendering engine: activate to sort column ascending"><a href="javascript:void(0);" onclick="applysortfilte_contact('highest_qualification', '<?php echo $sorttypepass; ?>')">
                <?php echo $this->lang->line('common_label_highest_qualification_sort') ?>
                </a>
            </th>
            <th data-direction="desc" data-sortable="true" data-filterable="true" <?php
                if (isset($sortfield) && $sortfield == 'location') {
                    if ($sortby == 'asc') {
                        echo "class = 'sorting_desc'";
                    } else {
                        echo "class = 'sorting_asc'";
                    }
                }
                ?> role="columnheader" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="descending" aria-label="Rendering engine: activate to sort column ascending"><a href="javascript:void(0);" onclick="applysortfilte_contact('location', '<?php echo $sorttypepass; ?>')">
                <?php echo $this->lang->line('common_label_highest_location') ?>
                </a>
            </th>
            <th class="hidden-xs hidden-sm sorting_disabled" data-filterable="true" role="columnheader" rowspan="1" colspan="1" aria-label="CSS grade"><?php echo $this->lang->line('common_label_action') ?>
            </th>
        </tr>
    </thead>
<tbody>
    <?php
    if (!empty($datalist) && count($datalist) > 0)
    {
        $i = !empty($this->router->uri->segments[4]) ? $this->router->uri->segments[4] + 1 : 1;
        foreach ($datalist as $row) { ?>
            <tr <?php if ($i % 2 == 1) { ?>class="bgtitle" <?php } ?> >
                <td class="text-center">
                    <div class="" style="position: relative;">
                        <input type="checkbox" class="checkbox1" name="check[]" value="<?php echo $row['id'] ?>">
                    </div>
                </td>
                <td class="hidden-xs hidden-sm "><?= !empty($row['user_name']) ? ucfirst($row['user_name']) : '' ?></td>
                <td class="hidden-xs hidden-sm "><?= !empty($row['contact_no']) ? ucfirst($row['contact_no']) : '' ?></td>
                <td class="hidden-xs hidden-sm "><?= !empty($row['gender']) && $row['gender'] == 1 ? ucfirst('Male') : ucfirst('Female') ?></td>
                <td class="hidden-xs hidden-sm "><?= !empty($row['highest_qualification']) ? ucfirst(substr($row['highest_qualification'], 0, 20)) : '-' ?></td>
                <td class="hidden-xs hidden-sm "><?= !empty($row['location']) ? ucfirst($row['location']) : '-' ?></td>

                <td class="hidden-xs hidden-sm text-center">
                    <?php if (!empty($row['status']) && $row['status'] == 1)
                    { ?>
                        <button class="btn btn-xs btn-success" title="Publish Record"  onclick="publishpopup('<?php echo $row['id'] ?>','publish');">
                            <i class="fa fa-check"></i>
                        </button>
                    <? }
                    else
                    { ?>
                        <button class="btn btn-xs btn-success" title="Unpublish Record"  onclick="publishpopup('<?php echo $row['id'] ?>','unpublish');">
                            <i class="fa fa-ban"></i>
                        </button>
                    <?php
                    }
                    ?>
                    <a class="btn btn-xs btn-success" href="<?= $this->config->item('admin_base_url'); ?>register/edit_record/<?= $row['id'] ?>" title="Edit Record"><i class="fa fa-pencil"></i></a>  &nbsp;
                    <a class="btn btn-xs btn-success" href="javascript:void(0)" data-toggle="modal" data-target=".bs-upload-modal-sm" onclick="update_id(<?= $row['id'] ?> , '<?= !empty($row['pic'])?$row["pic"]:"" ?>')" title="Upload profile photo"><i class="fa fa-upload"></i></a>  &nbsp;
                    <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target=".bs-example-modal-sm" title="View Record Details" onclick="load_user_detals(<?= $row['id'] ?>)"><i class="fa fa-external-link"></i></button>
                    <button class="btn btn-xs btn-primary" title="Delete Record"  onclick="deletepopup1('<?php echo $row['id'] ?>', '<?php echo $row['user_name'] ?>');"> <i class="fa fa-times"></i> </button>
                    <input type="hidden" id="sortfield" name="sortfield" value="<?php if (isset($sortfield)) echo $sortfield; ?>" />
                    <input type="hidden" id="sortby" name="sortby" value="<?php if (isset($sortby)) echo $sortby; ?>" />
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td class="text-center" colspan="6">
                No Record Found
            </td>
        </tr>
    <?php } ?>
</tbody>
</table>
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
