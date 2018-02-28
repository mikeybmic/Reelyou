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
                        <?php load_view('includes/left-menu.php'); ?>


                        <div class="col-md-9 col-sm-8">
                            <div class="row">
                                <div class="profile-cont">
                                    <div class="profile-header">
                                        <h3>Kristen Ransom</h3>
                                        <ul class="conversation-menu">
                                            <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/likes-icon.png" alt="" title=""></a></li>
                                            <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/conversation-icon.png" alt="" title=""></a></li>
                                            <li><a href="#"><img src="<?php echo base_url(); ?>assets/images/phone-icon.png" alt="" title=""></a></li>
                                            <div class="clear"></div>
                                        </ul>
                                        <div class="clear"></div>
                                    </div>

                                    <?php $this->load->helper('url'); ?>
                                    <table width="100%" border="1" style="border-collapse:collapse; border-color:#CCCCCC;" cellpadding="4" cellspacing="4">
                                        <td style="padding:10px;">
                                                <a href="<?php echo site_url()."pm" ?>">Inbox</a> &nbsp;&nbsp;&nbsp;
                                                <!--<a href="<?php //echo site_url()."/pm/messages/".MSG_UNREAD         ?>">Unread</a> &nbsp;&nbsp;&nbsp;--> 
                                                <a href="<?php echo site_url()."/pm/messages?type=".MSG_SENT?>">Sent</a> &nbsp;&nbsp;&nbsp;
                                                <!--<a href="<?php //echo site_url()."/pm/messages/".MSG_DELETED         ?>">Trashed</a> &nbsp;&nbsp;&nbsp;-->
                                                <a href="<?php echo site_url()."pm/send" ?>">Compose</a>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </td>
                                    </table>
                                    <br />

                                    <?php if (count($messages) > 0): ?>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr style="background: #ccc;">
                                                
                                                <td width="30%" style="font-weight:bold; padding:4px;">
                                                    <?php
                                                    if ($type != MSG_SENT)
                                                        echo 'From';
                                                    else
                                                        echo 'Recipients';
                                                    ?>
                                                </td>
                                                <td width="30%" style="font-weight:bold; padding:4px;">
                                                    Subject
                                                </td>
                                                <td width="20%" style="font-weight:bold; padding:4px;">
                                                    Date
                                                </td>
                                                <?php /* if ($type != MSG_SENT): ?>
                                                    <td width="10%" style="font-weight:bold;padding:4px;">
                                                        Reply
                                                    </td>
                                                <?php endif; */?>
                                                <td width="10%" align="center" style="font-weight:bold; padding:4px;">
                                                    <?php
                                                    if ($type != MSG_DELETED)
                                                        echo 'Delete';
                                                    else
                                                        echo 'Restore';
                                                    ?>
                                                </td>
                                                
                                            </tr>

                                            <?php for ($i = 0; $i < count($messages); $i++): 
                                                $bg = ($i%2 == 0)?'background:#FCFBF3;':'background:#eee;';
                                                ?>
                                                <tr style="<?php echo $bg; ?>">
                                                    <td style="padding:4px;">
                                                        <?php
                                                        if ($type != MSG_SENT)
                                                            echo $messages[$i][TF_PM_AUTHOR];
                                                        else {
                                                            $recipients = $messages[$i][PM_RECIPIENTS];
                                                            foreach ($recipients as $recipient)
                                                                echo (next($recipients)) ? $recipient.', ' : $recipient;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td style="padding:4px;">
                                                        <a href='<?php echo site_url().'/pm/message/'.$messages[$i][TF_PM_ID]; ?>'><?php echo (strlen($messages[$i][TF_PM_BODY]) > 20)? substr($messages[$i][TF_PM_BODY],0,20)."...":$messages[$i][TF_PM_BODY]; ?></a>
                                                    </td>
                                                    <td style="padding:4px;">
                                                        <?php echo $messages[$i][TF_PM_DATE]; ?>
                                                    </td>
                                                    <?php /*if ($type != MSG_SENT): ?>
                                                        <td style="padding:4px;">
                                                            <?php echo '<a href="'.site_url().'/pm/send/'.$messages[$i][TF_PM_AUTHOR].'/RE&#58;'.$messages[$i][TF_PM_SUBJECT].'"> reply </a>' ?>
                                                        </td>
                                                    <?php endif; */?>
                                                    <td style="padding:4px;" align="center">
                                                        <?php
                                                        if ($type != MSG_DELETED)
                                                            echo '<a href="'.site_url().'/pm/delete/'.$messages[$i][TF_PM_ID].'/'.$type.'"> x </a>';
                                                        else
                                                            echo '<a href="'.site_url().'/pm/restore/'.$messages[$i][TF_PM_ID].'"> o </a>';
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endfor; ?>
                                        </table>
                                    <?php else: ?>
                                        <h1>No messages found.</h1>
                                    <?php endif; ?>



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


