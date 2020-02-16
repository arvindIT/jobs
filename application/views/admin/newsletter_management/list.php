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
$viewname       = $this->router->uri->segments[2];
$admin_session  = $this->session->userdata('jow_admin_session');
$head_title     = $this->lang->line('label_newsletter_management');
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h4><?php echo $head_title ?></h4>
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
                        <select name="DataTables_Table_0_length" size="1" aria-controls="DataTables_Table_0" id="delete_all" onchange="delete_all_multipal(this.value)">
                            <option value="">Select</option>
                            <option value="delete">Delete</option>
                            <option value="publish">Publish</option>
                            <option value="unpublish">Unpublish</option>
                        </select>
                        <a class="btn btn-xs btn-success" href="<?php echo $this->config->item('admin_base_url')?>newsletter_management/add_record" title="<?= $this->lang->line('common_label_newsletter_management_new')?>"><i class="fa fa-plus-circle"></i>&nbsp;<?php echo $this->lang->line('common_label_newsletter_management_new')?></a>
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input class="" type="hidden" name="uri_segment" id="uri_segment" value="<?php echo !empty($uri_segment)?$uri_segment:'0'?>">
                                <input type="text" class="form-control"  name="searchtext" id="searchtext" aria-controls="DataTables_Table_0" placeholder="Search..." value="<?php echo !empty($searchtext)?$searchtext:''?>">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" onclick="contact_search('changesearch')" title="Search" type="button">Go!</button>
                                </span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <?php echo $this->load->view('admin/' . $viewname . '/ajax_list') ?>
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
            url: "<?php echo base_url(); ?>admin/newsletter_management/" + uri_segment,
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
                $.blockUI({message: '<?php echo '<img src="' . base_url('images') . '/ajaxloader.gif" border="0" align="absmiddle"/>' ?>'});
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
        var msg = 'Are you sure want to delete Record(s)';
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
            data: {'myarray': myarray, 'single_remove_id': id},
            success: function (data) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('admin_base_url') . $viewname ?>/" + data,
                    data: {
                        result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val(), allflag: ''
                    },
                    beforeSend: function () {
                        $('.x_content').block({message: 'Loading...'});
                    },
                    success: function (html) {
                        $(".x_content").html(html);
                        $('.x_content').unblock();
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
            $("option:selected").prop("selected", false)
            return false;

        }
        else
        {
            if (val == 'delete')
            {
                var msg = "<?php echo $this->lang->line('common_label_delete_record') ?>";
            }
            if (val == 'publish')
            {
                var msg = "<?php echo $this->lang->line('common_label_publish_record') ?>";
            }
            if (val == 'unpublish')
            {
                var msg = "<?php echo $this->lang->line('common_label_unpublish_record') ?>";
            }
            $.confirm({'title': 'CONFIRM', 'message': " <strong> " + msg + " " + "<strong></strong>", 'buttons': {'Yes': {'class': '',
                'action': function () {
                    delete_multipal(val);
            }}, 'No': {'class': 'special'}}});
        }


    }

    function delete_multipal(val)
    {
        var myarray = new Array;
        var i = 0;
        var boxes = $('input[name="check[]"]:checked');
        $(boxes).each(function () {
            myarray[i] = this.value;
            i++;
        });
        if (val == 'delete')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/ajax_delete_all'; ?>";
        }
        if (val == 'publish')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/ajax_publish_all'; ?>";
        }
        if (val == 'unpublish')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/ajax_unpublish_all'; ?>";
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
                    url: "<?php echo $this->config->item('admin_base_url') . $viewname ?>/" + data,
                    data: {
                        result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val(), allflag: ''
                    },
                    beforeSend: function () {
                        $('.x_content').block({message: 'Loading...'});
                    },
                    success: function (html) {
                        $(".x_content").html(html);
                        $('.x_content').unblock();
                    }
                });
                return false;
            }
        });
    }

    function publishpopup(id, status)
    {
        if(status != '' && status == 'unpublish')
        {
            var msg = "<?php echo $this->lang->line('common_label_publish_record'); ?>";
        }
        else
        {
            var msg = "<?php echo $this->lang->line('common_label_unpublish_record'); ?>";
        }
        $.confirm({'title': 'CONFIRM', 'message': " <strong> " + msg + " " + "<strong></strong>", 'buttons': {'Yes': {'class': '',
            'action': function () {
                change_status(id,status);
        }}, 'No': {'class': 'special'}}});
    }

    function change_status(id , status)
    {
        if(status != '' && status == 'publish')
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/unpublish_record'; ?>";
        }
        else
        {
            var url = "<?php echo $this->config->item('admin_base_url') . $viewname . '/publish_record'; ?>";
        }
        $.ajax({
            type: "POST",
            url: url+'/'+id,
            dataType: 'json',
            async: false,
            success: function (data) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo $this->config->item('admin_base_url') . $viewname ?>/" + data,
                    data: {
                        result_type: 'ajax', searchreport: $("#searchreport").val(), perpage: $("#perpage").val(), searchtext: $("#searchtext").val(), sortfield: $("#sortfield").val(), sortby: $("#sortby").val(), allflag: ''
                    },
                    beforeSend: function () {
                        $('.x_content').block({message: 'Loading...'});
                    },
                    success: function (html) {
                        $(".x_content").html(html);
                        $('.x_content').unblock();
                    }
                });
                return false;
            }
        });
    }


</script>