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


                                    <br />
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-striped msg-thread" id="msg-thread">

                                            <tbody>
                                                <?php
												
												 foreach ($messages as $i => $msg) { 
                                                    if($msg['pmto_deleted'] == 1)
                                                        continue;
                                                    ?>   
                                                    <tr>
                                                        <td>
                                                            <img src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo $msg['profile_image']; ?>" width="30px" height="30px"/><?php echo $msg['privmsg_body'] ?>
                                                            <a msg="<?php echo $msg['privmsg_id']; ?>" class="del-msg float-right" href="#"> <span class="glyphicon glyphicon-remove"></span> </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                        <form action="" id="send-message-form" method="post">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="msg" id="msg" placeholder="Reply here" autofocus required="required"/>
                                                <input class="form-control" type="hidden" name="reciever" id="reciever" value="<?php echo $reciever; ?>"/>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default submit-message" type="submit">Go!</button>
                                                </span>
                                            </div><!-- /input-group -->

                                        </form>
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
<script>
//    DELETE A MESSAGE
    $(document).on('click', '.del-msg', function (e) {
        e.preventDefault();
        $this = $(this);
        var msg = $(this).attr('msg');

        var data = 'msg=' + msg;
        $.ajax({
            url: window.base_url + 'Pm/delete_message',
            data: data,
            type: 'POST',
            success: function (postBack) {

//                    console.log(result);
                if (postBack == 1) {

                    $this.parent('td').remove();
                } else {
                    return false;
                }
            }
        });
    });
//    SUBMIT A MESSAGE
    $(document).on('click', '.submit-message', function (e) {
        e.preventDefault();
        $this = $(this);
        var data = $('#send-message-form').serialize();
//
//        console.log(data);
//        return;
        $.ajax({
            url: window.base_url + 'Pm/send_message',
            data: data,
            type: 'POST',
            success: function (postBack) {
                var returnData = $.parseJSON(postBack);
//                    console.log(result);
                if (returnData.msg == 1) {
                    $('#send-message-form')[0].reset();
                    $('#msg-thread tbody').append(returnData.result);
                } else {
                    $('#msg').attr('placeholder', 'Error sending message, try again.');
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
    .msg-thread tbody img{    border-radius: 15px;display: block;float: left;margin-right: 10px;}
</style>