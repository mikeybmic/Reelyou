<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<!--Content-->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="profile">
                        <!--left menu-->


                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="profile-cont">


                                    <?php $this->load->helper('url'); ?>
                                    <table width="100%" border="1" style="border-collapse:collapse; border-color:#CCCCCC;" cellpadding="4" cellspacing="4">
                                        <td style="padding:10px;">
                                            <!--<a href="<?php // echo site_url()."pm"          ?>">Inbox</a> &nbsp;&nbsp;&nbsp;-->
                                            <!--<a href="<?php //echo site_url()."/pm/messages/".MSG_UNREAD                     ?>">Unread</a> &nbsp;&nbsp;&nbsp;--> 
                                            <!--<a href="<?php // echo site_url()."/pm/messages?type=".MSG_SENT          ?>">Sent</a> &nbsp;&nbsp;&nbsp;-->
                                            <!--<a href="<?php //echo site_url()."/pm/messages/".MSG_DELETED                     ?>">Trashed</a> &nbsp;&nbsp;&nbsp;-->
                                            <a href="<?php echo site_url()."pm/send" ?>">Compose</a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </td>
                                    </table>
                                    <br />
                                    <div class="col-sm-10">
                                        <table class="table table-bordered table-striped msg-senders">
                                            <thead>
                                                <tr>
                                                    <th>Users</th>
                                                    <th>Last message</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if (!empty($senders)) {
                                                    foreach ($senders as $i => $sender) {
                                                        ?>   
                                                        <tr class="thread-row">
                                                            <td><a href="<?php echo base_url('Pm/thread?i=').$sender['id']; ?>"><?php echo $sender['name'] ?></a></td>
                                                            <td><?php echo (strlen($sender['last_msg']) > 20) ? substr($sender['last_msg'], 0, 20).'...' : $sender['last_msg']; ?></td>
                                                            <td class="col-sm-2"><button thread="<?php echo $sender['id']; ?>" class="btn btn-default btn-danger del-thread">Delete</button></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                }
                                                else {
                                                    ?>
                                                    <tr><td colspan="3">No messages yet.</td></tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>	
    </div>
</div>

<!--dialog-->
<div class="hidden">
    <div id="dialog-confirm-thread" title="Delete Confirmation">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span> Are you sure you want to delete this thread?</p>
    </div>
</div>
<script>
//        delete post
    $('.del-thread').on('click', function () {
        var $this = $(this);
        $("#dialog-confirm-thread").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Yes": function () {
                    var thisdialog = $(this);
                    var thread = $this.attr('thread');
                    var data = 'thread=' + thread;
                    $.ajax({
                        url: window.base_url + 'Pm/delete_thread',
                        data: data,
                        type: 'POST',
                        success: function (postBack) {

//                    console.log(result);
                            if (postBack == 1) {
                                $(thisdialog).dialog("close");
                                $($this).parents('.thread-row').remove();
                            } else {
                                return false;
                            }
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    });
</script>


<style>

    .msg-senders thead{background-color: #5f9ea0 !important;}
    .msg-senders tbody tr:nth-child(even){background: #ccc !important;}
    .msg-senders tbody tr td{}
    .msg-senders tbody tr a{display: block;}
</style>