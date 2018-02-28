<?php 
require FCPATH. '/vendor/autoload.php';

  foreach ($posts as $post) {
										
									if($post['post_pin']==1){
									$triangle_image		=	base_url().'assets/images/chat-arrow-blue.png';	
									}else{
									$triangle_image		=	base_url().'assets/images/chat-arrow.png';		
									}	
										
									 $postData = get_post_data($post['post_id']);
                						if ($post['post_type'] == 1) {	
									?>
                                    
                                    
									<div class="chat-outer">
										<div class="chat-box">
											<div class="chat-box-upper <?php if($post['post_pin']==1){ echo 'pin-post';}?>">
												<div class="chat-popup">
													<h3><?php echo $post['title']; ?></h3>
                                                    <div class="clearfix"></div>
													<div class="chat-content">
                                                    
                                                     <?php foreach ($postData as $image) { 
													if (file_exists(FCPATH.'/assets/images/post_images/'.$image['content'])) {
													?>
													<img data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/<?php echo $image['content']; ?>" src="<?php echo base_url() ?>assets/images/post_images/<?php echo $image['content']; ?>" alt="" title="">
												<?php }else{ ?>
												<img data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/dummy.png" src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/dummy.png" alt="" title="">
											   <?php } } ?>
                                                    
                                                    
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
												<div class="avatar-img">
                                                
                                               <?php if (file_exists(FCPATH.'/assets/images/profile_images/'.$userData['profile_image']) && $userData['profile_image']!='')  {?> 
                                                <img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title="">
                                                <?php }else{?>
                                                 <img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/avatar-2.png" alt="" title="">
                                                <?php }?>
                                                
                                                </div>
												<div class="avatar-title"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></div>
											</div>
										</div>
									</div>
                                    
                                    
                                    <?php } else if ($post['post_type'] == 3) {
                    ?>
                    <div class="chat-outer">
                        <div class="chat-box">
                            <div class="chat-box-upper <?php if($post['post_pin']==1){ echo 'pin-post';}?>">
                                <div class="chat-popup">
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
                }else{?>
									<div class="chat-outer">
										<div class="chat-box">
											<div class="chat-box-upper <?php if($post['post_pin']==1){ echo 'pin-post';}?>">
												<div class="chat-popup">
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
												<div class="avatar-img">
                                                <?php if (file_exists(FCPATH.'/assets/images/profile_images/'.$userData['profile_image']) && $userData['profile_image']!='')  {?> 
                                                <img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title="">
                                                <?php }else{?>
													<img class="img-circle" width="38px" height="38px" src="<?php echo base_url() ?>assets/images/avatar-2.png" alt="" title="">
													<?php }?>
                                                
                                                </div>
												<div class="avatar-title"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></div>
											</div>
										</div>
									</div>
                                    
									  <?php 
                                        }
                                      } ?>