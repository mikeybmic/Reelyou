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
                                    <div class="form-horizontal">
                                        <?php if (count($message) > 0): ?>
                                            <div class="form-group">
                                                <label for="Subject" class="col-sm-2 control-label">Subject</label>
                                                <div class="col-sm-10">
                                                    <input type="text" value="<?php echo $message[TF_PM_SUBJECT]; ?>" disabled="disabled" class="form-control" id="inputEmail3" placeholder="Email">
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label for="From" class="col-sm-2 control-label">From</label>
                                                <div class="col-sm-10">
                                                    <input type="text" value="<?php echo $message[TF_PM_AUTHOR]; ?>" disabled="disabled" class="form-control" id="inputEmail3" placeholder="Email">
                                                </div>
                                            </div>
                                            
                                           <div class="form-group">
                                                <label for="To" class="col-sm-2 control-label">To</label>
                                                <div class="col-sm-10">
                                                    <?php
                                                    foreach ($message[PM_RECIPIENTS] as $recipient)
                                                        echo (next($message[PM_RECIPIENTS])) ? $recipient.', ' : $recipient;
                                                    ?>
                                                </div>
                                            </div>
                                        
                                        
                                           <div class="form-group">
                                                <label for="Date" class="col-sm-2 control-label">Date</label>
                                                <div class="col-sm-10">
                                                    <input type="text" value="<?php echo $message[TF_PM_DATE]; ?>" disabled="disabled" class="form-control" id="inputEmail3" placeholder="Email">
                                                </div>
                                            </div>
                                           <div class="form-group">
                                                <label for="Date" class="col-sm-2 control-label">Date</label>
                                                <div class="col-sm-10">
                                                    <textarea class="form-control" disabled="disabled"><?php echo $message[TF_PM_BODY]; ?></textarea>
                                                </div>
                                            </div>

                                        <?php else: ?>
                                            <h1>No message found.</h1>
                                        <?php endif; ?>
                                    </div>
                                    <!--details-->
                                    
                                    <!--end details-->


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



