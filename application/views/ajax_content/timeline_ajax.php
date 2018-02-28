<?php
require FCPATH. '/vendor/autoload.php';

        if (!empty($posts)) {
            foreach ($posts as $post) {
//                $timestamp = (int) strtotime($post['created']);
				$userData = $this->profile_model->getUserInfo($post['user_id']);
                $postData = get_post_data($post['post_id']);
				
				if($post['post_pin']==1){
				$triangle_image		=	base_url().'assets/images/chat-arrow-blue.png';	
				}else{
				$triangle_image		=	base_url().'assets/images/chat-arrow.png';		
				}
				
                if ($post['post_type'] == 1) {
                    ?>

                    <div class="chat-outer">
                        <div class="chat-box">
                            <div class="chat-box-upper <?php if($post['post_pin']==1){ echo 'pin-post';}?>">
                                <div class="chat-popup">

                                    <!--actions buttons-->
                                    <div class="btn-group float-right profile-action-dropdown">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                           <?php if($post['user_id']==$curuserData['user_id']){?>
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <?php }?>
                                            <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                            
                                            <?php if($post['post_pin']==1 && $post['user_id']==$curuserData['user_id']){?>
                                            <li><a href="javascript:void(0)" class="unpin-post" post="<?php echo $post['post_id']; ?>">Remove Pin</a></li>
                                           <?php }else if($post['user_id']==$curuserData['user_id']){?> 
                                            
                                            <li><a href="javascript:void(0)" class="makepin-post" post="<?php echo $post['post_id']; ?>">Pin Post</a></li>
                                            <?php }?>
                                            
                                        </ul>
                                    </div>
                                    <!--actions buttons-->

                                    <h3><?php echo $post['title']; ?></h3>
                                    <div class="clearfix"></div>
                                    <div class="chat-content">
                                        <?php
										
										
                                        foreach ($postData as $image) {
                                            if (file_exists(FCPATH.'assets/images/post_images/'.$image['content'])) {
                                                ?>
                                                <img data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/<?php echo $image['content']; ?>" src="<?php echo base_url() ?>assets/images/post_images/<?php echo $image['content']; ?>" alt="" title="">
                                                <?php
                                            }
                                            else {
                                                ?>
                                                <img data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/dummy.png" src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/dummy.png" alt="" title="">
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="row comments-box">
                                        <?php
                                    $comment_section = new CommentSection($post['post_id']);
                                    $comment_section->doComments();
									?>
                                     </div> 
                                	

                                </div>
                               
                            </div>
                             <div class="bottom-arrow"><img src="<?php echo $triangle_image?>" alt="" title=""></div>
                            <div class="chat-box-bottom">
                                <div class="avatar-img"><img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
                                <div class="avatar-title"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                else if ($post['post_type'] == 3) {
                    ?>
                    <div class="chat-outer">
                        <div class="chat-box">
                            <div class="chat-box-upper <?php if($post['post_pin']==1){ echo 'pin-post';}?>">
                                <div class="chat-popup">
                                	<div class="btn-group float-right profile-action-dropdown">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                        <?php if($post['user_id']==$curuserData['user_id']){?>
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <?php }?>
                                        <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                        <?php if($post['post_pin']==1 && $post['user_id']==$curuserData['user_id']){?>
                                            <li><a href="javascript:void(0)" class="unpin-post" post="<?php echo $post['post_id']; ?>">Remove Pin</a></li>
                                           <?php }else if($post['user_id']==$curuserData['user_id']){?> 
                                            
                                            <li><a href="javascript:void(0)" class="makepin-post" post="<?php echo $post['post_id']; ?>">Pin Post</a></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                
                                    <h3><?php echo $post['title']; ?></h3>
                                    <div class="clearfix"></div>
                                    <div class="chat-content">
                                        <?php foreach ($postData as $image) { ?>
                                            <img data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo $image['content']; ?>" src="<?php echo $image['content']; ?>" alt="" title="">

                                        <?php }
                                        ?>
                                    </div>
                                    
                                     <div class="row comments-box">
                                        <?php
                                    $comment_section = new CommentSection($post['post_id']);
                                    $comment_section->doComments();
									?>
                                     </div> 
                                	
                                    
                                
                                  
                                        
                                    </div>

                                  
                                </div>
                                
                            </div>
                            <div class="bottom-arrow"><img src="<?php echo $triangle_image?>" alt="" title=""></div>
                            <div class="chat-box-bottom">
                                <div class="avatar-img"><img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
                                <div class="avatar-title"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></div>
                            </div>
                        </div>
                    
                    <?php
                }
                else {
					
                    ?>
                    <div class="chat-outer">
                        <div class="chat-box">
                            <div class="chat-box-upper <?php if($post['post_pin']==1){ echo 'pin-post';}?>">
                                <div class="chat-popup">
                                    <!--actions buttons-->
                                    <div class="btn-group float-right profile-action-dropdown">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                        <?php if($post['user_id']==$curuserData['user_id']){?>
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <?php }?>
                                        <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                          <?php if($post['post_pin']==1 && $post['user_id']==$curuserData['user_id']){?>
                                            <li><a href="javascript:void(0)" class="unpin-post" post="<?php echo $post['post_id']; ?>">Remove Pin</a></li>
                                           <?php }else if($post['user_id']==$curuserData['user_id']){?> 
                                            
                                            <li><a href="javascript:void(0)" class="makepin-post" post="<?php echo $post['post_id']; ?>">Pin Post</a></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <!--actions buttons--> 
                                    <h3><?php echo $post['title']; ?></h3>
                                    <div class="chat-content">
                                    <?php foreach ($postData as $cont) {
										echo $cont['content'];
                                    }?>
                                    </div>
                                    
                                   <div class="row comments-box">
                                        <?php
                                    $comment_section = new CommentSection($post['post_id']);
                                    $comment_section->doComments();
									?>
                                     </div> 
                                	
                                    
                                </div>
                                
                            </div>
                            <div class="bottom-arrow"><img src="<?php echo $triangle_image?>" alt="" title=""></div>
                            <div class="chat-box-bottom">
                                <div class="avatar-img"><img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
                                <div class="avatar-title"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        }
        ?>