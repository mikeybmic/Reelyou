<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($userData);exit;
$curUser = currentuser_session();
require FCPATH. '/vendor/autoload.php';

?>

<!--Content-->
<div class="center-content">
							<div class="profile-view-cont">
								<div class="banner-img">
                               
                                
                                	<?php if (file_exists(FCPATH.'/assets/images/banner_images/'.$userData['profile_banner']) && $userData['profile_banner']!='')  {?>
									<img id="ban_img" src="<?php echo base_url(); ?>assets/images/banner_images/<?php echo $userData['profile_banner']; ?>" alt="" title="">
                                    
                                   <?php }else{?>
                                   <img id="ban_img" src="<?php echo base_url(); ?>assets/images/banner_images/profile-banner.jpg" alt="" title="">
                                   <?php }?>
                                   <?php if($userData['user_id']==$curUser['user_id']){?>
                                         
                                        <span class="glyphicon glyphicon-pencil" id="edit-banner" aria-hidden="true"></span>
                                        <?php }?>
                                        
                                        
                                   
                                   
								</div>
                                <div class="spacer-15"></div>
								<div class="profile-detail">
									<div class="profile-line">
										
										<h2><?php echo $userData['first_name']; ?> <?php echo $userData['last_name']; ?></h2>
                                        
                                        <?php if($userData['user_id']!=$curUser['user_id']){?>
                                        
                                        	 <?php if ($relation == '1') { ?>
                                                    <a href="javascript:void(0)" user="<?php echo $userData['user_id']; ?>" class="add-friend un-friend" >Unfriend</a>
                                                    <?php
                                                }
                                                else if ($relation == '0') {
                                                    ?>
                                                    <a href="javascript:void(0)" user="<?php echo $userData['user_id']; ?>" class="add-friend un-friend">Cancel Request</a>
                                                    <?php
                                                }
                                                else {
                                                    ?>
                                                    <a href="javascript:void(0)" user="<?php echo $userData['user_id']; ?>" class="add-friend connect-to">Add Friend</a>
                                                    
                                                    
                                                <?php } ?>	
                                                
                                            
                                         <?php }?>

                                         
									</div>
									<div class="profile-line">
										<p id="pro_desc"><?php echo $userData['profile_desc']; ?> </p>
									</div>
									<div class="small-info">
                                    	<div class="info-line">Passion: <span><?php echo $userData['interest']; ?></span></div>
										<div class="info-line">State: <span><?php echo $userData['state']; ?></span></div>
										<div class="info-line">City: <span><?php echo $userData['city']; ?></span></div>
										
									</div>
                                    <?php 
									if (!empty($posts) && ($userData['user_id']==$curUser['user_id'] || $relation==1)) {?>
                                    
									<div class="timeline-outer">
										<div class="title-text">Timeline</div>
										<div class="time-line-cont">
											<div class="fill"></div>
										</div>
									</div>
                                    <div id="ajax_content">
                                   <?php 
                                    
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
                                      } }?>
                                      
                                      
                                    </div>  
                                      
								</div>
							</div>
</div>
                        
                        
  <div class="hidden">
    <div id="dialog-confirm" title="Delete Confirmation">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span> Are you sure you want to delete this post?</p>
    </div>

    <div id="delete-comment" title="Comment Deletion">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Are you sure you want to delete this comment?</p>
    </div>

    <!--// REPORT A POST-->
    <div id="report-post-dialog" title="Report Post">
        <div class="radio">
            <label>
                <input type="radio" name="report-post" value="1"> It is a spam
            </label>
            <div class="clearfix"></div>
            <label>
                <input type="radio" name="report-post" value="2"> It is annoying
            </label>
        </div>
    </div>
</div> 
 <style type="text/css">
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
  	</style>                        
 
<input type="hidden" name="num_rows" id="num_rows" value="0" />
<div class="ajax-load text-center" style="display:none">
	<p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
</div>

<script type="text/javascript">

var page = 0;
	$(window).scroll(function() {
	    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
			if($('#num_rows').val()==0){
	        page++;
	        loadMoreData(page);
			}
	    }
	});

	function loadMoreData(page){
		
			
	  $.ajax(
	        {
	            url: window.base_url + 'Profile/ajax_profile/<?php echo $visitUserID?>/'+ page,
	            type: "get",
	            beforeSend: function()
	            {
	                $('.ajax-load').show();
	            }
	        })
	        .done(function(data)
	        {
	            if(data ==1){
					$('#num_rows').val(1);
					$('.ajax-load').show();
	                $('.ajax-load').html("No more posts to display");
					$()
	                return;
	            }
	            $('.ajax-load').hide();
	            $("#ajax_content").append(data);
	        })
	        .fail(function(jqXHR, ajaxOptions, thrownError)
	        {
	              alert('server not responding...');
	        });
	}	




    $(document).ready(function () {
        $(document).on('click', '.connect-to', function (e) {
//            console.log('connect');
            e.preventDefault();
            var $this = $(this);
            var user = $(this).attr('user');
            console.log(user);
            var data = 'user=' + user;
            $.ajax({
                type: 'POST',
                data: data,
                url: window.base_url + 'Users/connect_to',
                success: function (postBack) {
//                    console.log(postBack);
                    var data = $.parseJSON(postBack);
                    if (data.msg == 1) {
                        $($this).text('Cancel Request').removeClass('connect-to').addClass('un-friend').css({'background': '#fa5a5a', 'color': '#fff'});
                    } else {
                        return false;
                    }
                }
            });

        });


        $(document).on('click', '.un-friend', function (e) {
            e.preventDefault();
            var $this = $(this);
            var user = $(this).attr('user');
            var data = 'user=' + user;
            $.ajax({
                type: 'POST',
                data: data,
                url: window.base_url + 'Users/unfriend',
                success: function (postBack) {
//                    console.log(postBack);
                    var data = $.parseJSON(postBack);
                    if (data.msg == 1) {
                        $($this).text('Add Friend').removeClass('un-friend').addClass('connect-to').css('background', '#80befc');
                    } else {
                        return false;
                    }
                }
            });

        });


        $('#dob').datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: "-100:+0"
        });


        $('#state').on('change', function (e) {
            var state = $(this).val();
            //            console.log(state);
            $.ajax({
                type: 'POST',
                url: window.base_url + 'Profile/getCities',
                data: 'state=' + state,
                success: function (callBack) {
                    var data = $.parseJSON(callBack);
                    var citiesList = '';
                    $.each(data, function (key, val) {
                        var selected = '';
                        if (val.id == "<?php echo $userData['city']; ?>") {
                            selected = 'selected="selected"';
                        }
                        citiesList += '<option value="' + val.id + '" ' + selected + '>' + val.name + '</option>';
                    });
                    $('#city').html(citiesList);
                    //                    console.log(temp);
                }
            });

        }).trigger('change');

        $('#city').on('change', function (e) {

            var state = $('#state option:selected').text();
            var city = $("#city option:selected").text();

            $.ajax({
                type: 'POST',
                url: window.base_url + 'Profile/getZipCode',
                data: 'state=' + state + 'city=' + city,
                beforeSend: function () {
                    $('#zip').val('');
                    $('#zip-preloader').removeClass('hidden');
                },
                success: function (callBack) {
                    var data = $.parseJSON(callBack);
                    //                    console.log(data);
                    $('#zip-preloader').addClass('hidden');
                    if (data.zip == null) {
                        $('#zip').attr('placeholder', 'Please type zip');
                    }
                    $('#zip').val(data.zip);
                }
            });

        })

    })
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.ajaxfileupload.js"></script>

<script>
    $("#filesToUploadP").AjaxFileUpload({

        action: '<?php echo base_url(); ?>Profile/profile_image',
        onComplete: function (filename, response) {
            $("#myProfileImage").attr('src', response.name);
            $(".myProfileImage").show();
            $("#current-profile-image").remove();
            $("#profilesrc").val(response.name);
            $('#myProfileImage').Jcrop({
                aspectRatio: 0.72,
                setSelect: [25, 40, 500, 254],
                onSelect: updateCoords
            });
        }
    });

    function updateCoords(c)
    {
        $('#x').val(c.x);
        $('#y').val(c.y);
        $('#w').val(c.w);
        $('#h').val(c.h);
    }
	
	
$(document).ready(function() {
	
	// Show reply box and hide-button, hide reply-button
	$(document).on('click', '.reply-button', function() {
		$(this).parent().children('.msg-text').show(); // Show textarea
		$(this).parent().children('.hide-reply-box').show(); // Show hide-button
		$(this).hide(); // Hide reply-button
		
		// Clear any previous errors and warnings
		$('.warning').hide();
		$('.error-com').hide();
		$('.warning p').html('');
		$('.error-com p').html('');
	});
	
	// Hide reply box and hide-button, show reply-button again
	$(document).on('click', '.hide-reply-box', function() {
		$(this).parent().children('.msg-text').hide();  // Hide textarea
		$(this).parent().children('.reply-button').show(); // Hide hide-button
		$(this).hide(); // Show reply-button
		
		// Clear any previous errors and warnings
		$('.warning').hide();
		$('.error-com').hide();
		$('.warning p').html('');
		$('.error-com p').html('');
	});
						
	// On enter insert reply
	$(document).on('keypress', '.msg-text textarea, .msg-text input', function(event) {
		 if (event.keyCode == 13 && event.shiftKey == false) {
			var msg_txt = $(this).parent('.msg-text').children('textarea').val().trim();
			var parent_id = $(this).parent('.msg-text').parent('.message-body').attr('id').slice(8);
			
			var post_id = $(this).parent('.msg-text').children('[name="post_id"]').val().trim();
			
			// Send comment and parent id to server via ajax
			$.ajax({
				url: window.base_url + 'Comments/inset_comment',
				type: 'post',
				dataType: 'json',
				data: {
					'msg': msg_txt, 
					'parent': parent_id, 
					'post_id': post_id
				},
				success: function (data) {
					if (data.status_code != 0) {
						// Display warning box with message
						if (data.status_code != 1 && data.status_code != 4) {
							$('.error-com').hide();
							$('.error-com p').html('');
							$('.warning p').html(data.status_msg.join('<br>'));
							$('.warning').show();
						}
						else {
							$('.warning').hide();
							$('.warning p').html('');
							$('.error-com p').html(data.status_msg.join('<br>'));
							$('.error-com').show();
						}
					}
					else {
						if (parent_id != '') {
							
							console.log('');
							// Insert new comment with id="data.message_id"
							$('#message-' + parent_id).after('<ul id="parent-of-'+ data.message_id +'"><li><ul  id="message-' + data.message_id + '" class="message-body"><li class="author"><img class="img-circle" width="31px" height="32px" src="'+data.profile_image+'"></li><li class="comment-msg">' + htmlEncode(msg_txt) + '</li><li class="delete-comment" onclick="delete_comment('+data.message_id+')"><i class="fa fa-times" aria-hidden="true"></i></li><li class="reply-button" style="display: list-item;">Reply</li><li class="msg-text" style="display: none;"><input type="hidden" name="post_id" value="' + post_id + '"><textarea></textarea></li><li class="hide-reply-box" style="display: none;">Click to hide</li></ul></li></ul>');
						}
						else {
							$('div#main-com_'+post_id+' > ul > li:first-child > .message-body:first-child').before('<ul  id="message-' + data.message_id + '" class="message-body"><li class="author"><img class="img-circle" width="31px" height="32px" src="'+data.profile_image+'"></li><li class="comment-msg">' + htmlEncode(msg_txt) + '</li><li class="delete-comment" onclick="delete_comment('+data.message_id+')"><i class="fa fa-times" aria-hidden="true"></i></li><li class="reply-button" style="display: list-item;">Reply</li><li class="msg-text" style="display: none;"><input type="hidden" name="post_id" value="' + post_id + '"><textarea></textarea></li><li class="hide-reply-box" style="display: none;">Click to hide</li></ul>');
						}
						
						// Hide reply box
						$('.hide-reply-box').click();
						
						// Clear any previous errors and warnings
						$('.warning').hide();
						$('.error-com').hide();
						$('.warning p').html('');
						$('.error-com p').html('');
					}
				}
			});
			return false;
		 }
	});
	
});

function htmlEncode(value){
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}

function delete_comment(commentId){
        $("#delete-comment").dialog({
            resizable: false,
            height: "auto",
            width: 400,
            modal: true,
            buttons: {
                "Yes": function () {
                    var thisdialog = $(this);
//                        var post = $this.attr('post');
                    var data = 'comment=' + commentId;
                    $.ajax({
                        url: window.base_url + 'Comments/delete_comment',
                        data: data,
                        type: 'POST',
                        success: function (postBack) {
                            var result = $.parseJSON(postBack);
//                    console.log(result);
                            if (result.msg == 1) {
                                $(thisdialog).dialog("close");
                               $("#parent-of-"+commentId).remove();
                            }else{
							$('.warning').hide();
							$('.warning p').html('');
							$('.error-com p').html(result.error);
							$('.error-com').show();	
							}
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
	
	
}


$( document ).ready(function() {
    $("#imgsupload").change(function() {
    $( "#edit_banner" ).trigger( "click" );
});
});



</script>

<div class="popup-box">
            <div id="bannerModal" class="modal fade custom-modal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                       
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> <i class="fa fa-times" aria-hidden="true"></i></button>
                        </div>
                        <div class="modal-body">
                            <div id="change_section">
                            <img src="<?php echo base_url()?>assets/images/banner_images/<?php echo (!empty($profileData['profile_banner'])) ? $profileData['profile_banner'] : 'profile-banner.jpg'; ?>" alt="" title="" width="100%" height="90%">
                            </div>

                        
                         <form id="uploadForm" method="post" action="" enctype="multipart/form-data">
                            <div class="edit banner-popup">
                            
                             
                                <a href="javascript:void(0);" ><img class="openImgUpload" src="<?php echo base_url(); ?>assets/images/edit-img.png" alt="" title=""><span class="openImgUpload">Edit Banner</span>
                               
                                </a>
                                <input type="file" id="imgsupload" name="banner_pic" style="display:none"/>
                                <div id="error-msg"></div>
                                
                                <div class="clear"></div>
                                
                                
                                
                            </div>
                            
                            
                            <h6><textarea id="profile_desc" class="form-control" maxlength="140" rows="3" name="profile_desc" required=""><?php echo $profileData['profile_desc']; ?></textarea></h6>
                           
                            <button class="done blue-btn" id="edit_banner" type="submit">Done</button>
                            </form> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
