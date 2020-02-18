<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
?>
<script language="javascript">
    $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
    $(document).ready(function () {
        $.unblockUI();
    });
</script>
<?php
$viewname = $this->router->uri->segments[2];
$admin_session = $this->session->userdata('jow_admin_session');
$head_title = 'User Management';
?>
<!-- Model popup -->
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" style="width: 400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel2">User Details</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h4><?= $head_title ?></h4>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <select name="DataTables_Table_0_length" size="1" aria-controls="DataTables_Table_0" onchange="changepages();" id="perpage">
                            <option value="">Rows</option>
                            <option <?php
                            if (!empty($perpage) && $perpage == 10) {
                                echo 'selected="selected"';
                            }
                            ?> value="10">10</option>
                            <option <?php
                            if (!empty($perpage) && $perpage == 25) {
                                echo 'selected="selected"';
                            }
                            ?> value="25">25</option>
                            <option <?php
                            if (!empty($perpage) && $perpage == 50) {
                                echo 'selected="selected"';
                            }
                            ?> value="50">50</option>
                            <option <?php
                            if (!empty($perpage) && $perpage == 100) {
                                echo 'selected="selected"';
                            }
                            ?> value="100">100</option>
                        </select>
<!--                        <select name="DataTables_Table_0_length" size="1" aria-controls="DataTables_Table_0" id="delete_all" onchange="deletepopup1()">
                            <option value="">Select</option>
                            <option value="delete">Delete</option>
                            <option value="publish">Publish</option>
                            <option value="unpublish">Unpublish</option>
                        </select>-->
                        <a class="btn btn-xs btn-success" href="<?= $this->config->item('admin_base_url')?>register/" title="<?= $this->lang->line('common_label_users_management_new')?>"><i class="fa fa-plus-circle"></i>&nbsp;<?= $this->lang->line('common_label_users_management_new')?></a>
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input class="" type="hidden" name="uri_segment" id="uri_segment" value="<?=!empty($uri_segment)?$uri_segment:'0'?>">
                                <input type="text" class="form-control"  name="searchtext" id="searchtext" aria-controls="DataTables_Table_0" placeholder="Search..." value="<?=!empty($searchtext)?$searchtext:''?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" onclick="contact_search('changesearch')" title="Search" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?= $this->load->view('admin/' . $viewname . '/ajax_list') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function contact_search(allflag)
    {
        var uri_segment = $("#uri_segment").val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>admin/user_management/new_user/" + uri_segment,
            data: {
                result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val(), allflag: allflag
            },
            beforeSend: function () {
                $('.x_content').block({message: 'Loading...'});
            },
            success: function (html) {
                $(".x_content").html('');
                $(".x_content").html(html);
                $('.x_content').unblock();
            }
        });
        return false;
    }

    $(document).ready(function () {
        $('#searchtext').keyup(function (event)
        {
            if (event.keyCode == 13) {
                contact_search('changesearch');
            }
        });
    });

    function clearfilter_contact()
    {
        $("#searchtext").val("");
        $("#delete_all").val("");
        contact_search('all');
    }

    function changepages()
    {
        contact_search('');
    }

    function applysortfilte_contact(sortfilter, sorttype)
    {
        $("#sortfield").val(sortfilter);
        $("#sortby").val(sorttype);
        contact_search('changesorting');
    }

    $('body').on('click', '#common_tb a.paginclass_A', function (e)
    {
        $.ajax({
            type: "POST",
            url: $(this).attr('href'),
            data: {
                result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val()
            },
            beforeSend: function ()
            {
                $.blockUI({message: '<?= '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
            },
            success: function (html)
            {
                $(".x_content").html('');
                $(".x_content").html(html);
                $('.x_content').unblock();
                $.unblockUI();
            }
        });
        return false;
    });

    $('body').on('click', '#selecctall', function (e) {
        if (this.checked) {
            $('.checkbox1').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkbox1').each(function () {
                this.checked = false;
            });
        }
    });

    function deletepopup1(id, name)
    {
        var boxes = $('input[name="check[]"]:checked');
        if (boxes.length == '0' && id == '0')
        {
            $.confirm({'title': 'Alert', 'message': " <strong> Please select record(s) to delete. " + "<strong></strong>", 'buttons': {'ok': {'class': 'btn_center alert_ok'}}});
            $('#selecctall').focus();
            return false;
        }
        if (id == '0')
        {
            var msg = 'Are you sure want to delete Record(s)';
        }
        else
        {
            var msg = 'Are you sure want to delete ' + name + '?';
        }
        $.confirm({'title': 'CONFIRM', 'message': " <strong> " + msg + " " + "<strong></strong>", 'buttons': {'Yes': {'class': '',
            'action': function () {
                delete_all(id);
        }}, 'No': {'class': 'special'}}});
    }

    function delete_all(id)
    {
        var myarray = new Array;
        var i = 0;
        var boxes = $('input[name="check[]"]:checked');
        $(boxes).each(function () {
            myarray[i] = this.value;
            i++;
        });
        if (id != '0')
        {
            var single_remove_id = id;
        }
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('admin_base_url') . $viewname . '/ajax_delete_all'; ?>",
            dataType: 'json',
            async: false,
            data: {'myarray': myarray, 'single_remove_id': id},
            success: function (data) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('admin_base_url') . $viewname ?>/new_user/" + data,
                    data: {
                        result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val(), allflag: ''
                    },
                    beforeSend: function () {
                        $('#common_div').block({message: 'Loading...'});
                    },
                    success: function (html) {
                        $("#common_div").html(html);
                        $('#common_div').unblock();
                    }
                });
                return false;
            }
        });
    }

    $('#allcheck').click(function () {
        var val = $('#delete_all').val();
        if (val != '')
        {
            delete_all_multipal(val);
        }
        else
        {
            $.confirm({'title': 'Alert', 'message': " <strong> Please select atleast one Oparation (Delete / Publish / Unpublish) " + "<strong></strong>", 'buttons': {'ok': {'class': 'btn_center'}}});
        }
    });


    function delete_all_multipal(val)
    {
        var boxes = $('input[name="check[]"]:checked');
        if (boxes.length == '0')
        {
            $.confirm({'title': 'Alert', 'message': " <strong> Please select record(s) to " + val + ". " + "<strong></strong>", 'buttons': {'ok': {'class': 'btn_center alert_ok'}}});
            $('#selecctall').focus();
            return false;

        }
        var myarray = new Array;
        var i = 0;
        var boxes = $('input[name="check[]"]:checked');
        $(boxes).each(function () {
            myarray[i] = this.value;
            i++;
        });
        if (val == 'delete')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/new_user/ajax_delete_all'; ?>";
        }
        if (val == 'publish')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/new_user/ajax_publish_all'; ?>";
        }
        if (val == 'unpublish')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/new_user/ajax_unpublish_all'; ?>";
        }

        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            async: false,
            data: {'myarray': myarray},
            success: function (data) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('admin_base_url') . $viewname ?>/new_user/" + data,
                    data: {
                        result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val(), allflag: ''
                    },
                    beforeSend: function () {
                        $('#common_div').block({message: 'Loading...'});
                    },
                    success: function (html) {
                        $("#common_div").html(html);
                        $('#common_div').unblock();
                    }
                });
                return false;
            }
        });
    }


    function pubunpub_data(count1, id)
    {
        if (count1 == 1)
        {
            url = "<?php echo $this->config->item('admin_base_url') . $viewname; ?>/publish_record/" + id;
            html = '<a onclick="pubunpub_data(0,' + id + ');" href="javascript:void(0);" class="btn btn-xs btn-success"><i class="fa fa-check-circle"></i></a> &nbsp;';
            html1 = 'Active';
        }
        else
        {
            url = "<?php echo $this->config->item('admin_base_url') . $viewname; ?>/unpublish_record/" + id;
            html = '<a onclick="pubunpub_data(1,' + id + ');" href="javascript:void(0);" class="btn btn-xs btn-primary"><i class="fa fa-times-circle"></i></a> &nbsp;';
            html1 = 'Inactive';
        }
        $.ajax({
            type: "POST",
            url: url,
            async: false,
            success: function (data) {

                $(".pubunpub_span_" + id).html(html);
                $(".status_span_" + id).html(html1);

            }
        });
    }

    function load_user_detals(id)
    {
        $.ajax({
            type: "POST",
            url: "<?php echo $this->config->item('admin_base_url') . $viewname; ?>/load_user_detals/" + id,
            async: false,
            success: function (html) {
                $(".modal-body").html(html);
                $('.modal-body').unblock();
                return false;
            }
        });
    }
</script>