<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($assesmentData);exit;
$curUser = currentuser_session();
?>
<div class="center-content  new-post-page">
 <div class="assesment">
                                <h2>Setting</h2>

                                <div class="assesment-inner">
                                <?php if(validation_errors()!='')
								{?>
									<?php echo validation_errors();?>
									
									
								<?php }?>
                                
                                <?php if($this->session->userdata('sessionMessage')!='')
									{?>
									<p style="color:red; margin-left:16px;"><?php echo $this->session->userdata('sessionMessage');
									$this->session->unset_userdata('sessionMessage');?>
									</p>
								<?php }?>

                                    <form method="post" id="assesment-form" action="" enctype="multipart/form-data">
                                        <div class="col-sm-4">
                                            <input type="password"  name="old_password" placeholder="Old Password" class="form-control" value=""/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="password"  name="new_password" placeholder="New Password" class="form-control" value=""/>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="password"  name="con_password" placeholder="Confirm Password" class="form-control" value=""/>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="option-wrap" style="margin-top:10px;">
                                            <div class="form-group">
                                            <div class="col-sm-4 marginTop10">
                                                <select class="form-control" id="user_status" name="user_status">
                                                <option value="1" <?php if($profileData['user_status']==1){?> selected="selected" <?php }?>>Activate</option>
                                                <option value="0" <?php if($profileData['user_status']==0){?> selected="selected" <?php }?>>Deactivate</option>
                                               
                                            </select>
                                            </div>
                                            
                                            <div class="col-sm-4 marginTop10">
                                               <input type="text"  name="email_address" placeholder="Email Address" class="form-control" value="<?php echo $profileData['user_email']?>"/>
                                               <input type="hidden"  name="oldemail_address" class="form-control" value="<?php echo $profileData['user_email']?>"/>
                                            </div>
                                            
                                            
                                            <div class="clearfix"></div>
                                            
                                            </div>
                                            
                                        </div>

                                        <div class="clearfix"></div>
										 <div class="col-sm-12">
                                        <div class="asses-btn">
                                           
                                            <button class="blue-btn"  type="submit">Submit</button>
                                            <div class="clear"></div>
                                        </div>
                                        </div>
                                        
                                        
                                    </form>
                                    
                                    
                                </div>
                            </div>
</div>
                      
                      
                    