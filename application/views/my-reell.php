<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$this->load->helper('date');
$postsModel = model_load_model('Posts_model');



//profile image
$CI = get_instance();
$curUser = currentuser_session();
$userId = $curUser['user_id'];
$model = load_basic_model('profile');
require FCPATH. '/vendor/autoload.php';
$feeling = $curUser['feeling'];

?>

<div class="profile-view-cont">

<div class="row post-header">
                            <div class="col-sm-6">
                                <h3 class="name"><?php echo $userData['first_name'].' '.$userData['last_name']; ?></h3>
                            </div>
                            <div class="col-sm-6 text-right">
                                <h4>How are you feeling? 
                                <?php if ($feeling == '1') { ?>
                                <a href="javascript:void(0)"><i class="fa fa-thumbs-up feeling-1" aria-hidden="true"></i></a>
                                
                                <?php }else if ($feeling == '0') { ?>
                                <a href="javascript:void(0)"><i class="fa fa-thumbs-down feeling-0" aria-hidden="true"></i></a>
                                <?php }else{?>
                                <a href="javascript:void(0)" id="feeling-good" class="feelings"><i class="fa fa-thumbs-up" aria-hidden="true"></i></a>
                                <a href="javascript:void(0)" id="feeling-bad" class="feelings"><i class="fa fa-thumbs-down" aria-hidden="true"></i></a>
                                <?php }?>
                                
                                </h4>
                                
                            </div>
                           
                        </div>
                        
                         <hr/>
                         
                          <div class="row post-body">
                             <div class="col-sm-12">
                                <h3 class="blue-bg clearfix">My Reell
                                <a class="pull-right" href="<?php echo base_url('Profile/new_post'); ?>">+ &nbsp;Create Post</a>
                                </h3>
                                 
                                <hr>
                             </div>
                         </div>
                         
                         
                       

								
								<div class="profile-detail">
									
                                      
                                    <?php
                                    if (!empty($posts)) {
																				

										
                                        foreach ($posts as $post) {
                                            $timestamp = (int) strtotime($post['created']);
                                            $postData = get_post_data($post['post_id']);
											
											
										if($post['post_pin']==1){
										$triangle_image		=	base_url().'assets/images/chat-arrow-blue.png';	
										}else{
										$triangle_image		=	base_url().'assets/images/chat-arrow.png';		
										}
											
											
                                            ?>    
                                            
                                       <input type="hidden" name="post-id" value="<?php echo $post['post_id']; ?>"/>
                                 
										<?php if ($post['post_type'] == 1) {
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
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                         <?php if($post['post_pin']==1){?>
                                        <li><a href="javascript:void(0)" class="unpin-post" post="<?php echo $post['post_id']; ?>">Remove Pin</a></li>
                                       <?php }else{?> 
                                        
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
                                            if (file_exists(ROOT_PATH.'/assets/images/post_images/'.$image['content'])) {
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
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                        <?php if($post['post_pin']==1){?>
                                        <li><a href="javascript:void(0)" class="unpin-post" post="<?php echo $post['post_id']; ?>">Remove Pin</a></li>
                                       <?php }else{?> 
                                        
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
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                             <?php if($post['post_pin']==1){?>
                                        <li><a href="javascript:void(0)" class="unpin-post" post="<?php echo $post['post_id']; ?>">Remove Pin</a></li>
                                       <?php }else{?> 
                                        
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
									}?>
									
                                    
                                    
                                    
								</div>
							</div>


<!--confirmation dialog-->
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



<script type="text/javascript">
    $(document).ready(function () {
		
		$('.feelings').on('click', function () {
        var feeling = $(this).attr('id');
        $.ajax({
            url: window.base_url + 'Users/feeling',
            dataType: "json",
            method: "POST",
            data: {
                value: feeling
            },
            success: function (data) {
                console.log(data.feeling);
                if (data.feeling == 1) {
                    $('#feeling-bad').addClass('hidden');
                } else if (data.feeling == 0) {
                    $('#feeling-good').addClass('hidden');
                }
            }
        });
    });

        //        tag a friend
        $(document).on('keyup', '#comment', function (e) {
            var input = $(this).val();
//            console.log(input.substr(input.indexOf("@") + 1));
            if ($('#comment').val().indexOf('@') > -1) {
                $("#comment").autocomplete({
                    source: function (request, response) {

                        $.ajax({
                            url: window.base_url + 'Users/search_user',
                            dataType: "json",
                            data: {
                                value: input.substr(input.indexOf("@") + 1)
                            },
                            success: function (data) {
                                response(data);
                            }
                        });
                    },
                    minLength: 2,
                    select: function (event, ui) {
                        event.preventDefault();
                        var inputVal = input.substr(0, input.indexOf('@'));
                        var temp = '<input type="hidden" value="' + ui.item.id + '" name="tag-user[]"/>';
                        $(temp).appendTo($('#comment'));
                        $('#comment').val(inputVal.concat(ui.item.name));
                    }
                });
            }
        });
        
//comment box
        $('.comment').on('click', function (e) {
            e.preventDefault();
            $('.comment-box').remove();
            var post = $(this).parents('.post-courage').find('input[name="post-id"]').val();
            var commentBox = '<div class="row"><form method="post" class="comment-form form-horizontal col-sm-5 comment-box" action="">';
            commentBox += '<input type="text" name="comment" id="comment" class="form-control" placeholder="Your comment"/>';
            commentBox += '<input type="hidden" name="postId" value="' + post + '" class="form-control"/>';
            commentBox += '<input type="hidden" name="parent" value="0" class="form-control"/>';
            commentBox += '</form></div>';
            $(commentBox).insertAfter($(this).parent('.action-row'));
            $('input[name="comment"]').focus();
        });
        
//reply to a comment
        $('.comment-reply').on('click', function (e) {

            $('.comment-box').parent('div').remove();
            var post = $(this).parents('.post-courage').find('input[name="post-id"]').val();
            var parent = $(this).closest('.comment-row').attr('id');
            var commentBox = '<div class="row"><form method="post" class="comment-form form-horizontal col-sm-6 comment-box" action="">';
            commentBox += '<input type="text" name="comment" id="comment" class="form-control" placeholder="Your comment"/>';
            commentBox += '<input type="hidden" name="postId" value="' + post + '" class="form-control"/>';
            commentBox += '<input type="hidden" name="parent" value="' + parent + '" class="form-control"/>';
            commentBox += '</form></div>';
            $(commentBox).insertAfter($(this).closest('.comment-row'));
            $('input[name="comment"]').focus();
        });
//comment submit
        $(document).on('submit', 'form.comment-form', function (e) {
            e.preventDefault();
            var parentId = $('input[name="parent"]').val();
            var comment = $('#comment').val();
            var formData = $('form').serialize();
//console.log(formData);return;

            var tagUsers = [];
            $('input[name="tag-user[]"]').each(function () {
                tagUsers.push($(this).val());
            });
            if (comment.length == 0) {
                return false;
            }

            var splitData = formData.split('&');
            var commentId = splitData[3].split('=')[1];
            var data = 'data=' + formData + '&tagUser=' + tagUsers;
            $.ajax({
                url: window.base_url + 'Comments/new_comment',
                data: data,
                type: 'POST',
                success: function (postBack) {
                    var result = $.parseJSON(postBack);
//                    console.log(result);
                    if (result.msg == 1) {
//                        console.log(data);
                        var appendToDiv = $('form.comment-form').parents('.comment-row');
                        console.log(appendToDiv);
                        $('form.comment-form').remove();
                        if (parentId == '0') {
//                            if (appendToDiv.firstElementChild == 'ul') {
                            $(result.comment).appendTo('.comments-box');
//                            } else {
//                                var commentsBox = '<ul>' + result.comment + '</ul>';
//                                $(commentsBox).appendTo(appendToDiv);
//                            }
                        } else {
                            $(result.comment).appendTo($('#' + commentId));
                        }

                    }
                }
            });
        });
//post cross show hide
        $('.comment-row').on('mouseover', function () {
            $(this).find('.comment-del').removeClass('hidden');
        }).on('mouseout', function () {
            $(this).find('.comment-del').addClass('hidden');
        });
//remove a comment
        $(document).on('click', '.comment-del', function () {
            var $commentRow = $(this).closest('.comment-row');
            var commentId = $(this).closest('.comment-row').attr('id');
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
                                    $($commentRow).remove();
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
//        delete post
        $('.del-post').on('click', function () {
            var $this = $(this);
            $("#dialog-confirm").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Yes": function () {
                        var thisdialog = $(this);
                        var post = $this.attr('post');
                        var data = 'post=' + post;
                        $.ajax({
                            url: window.base_url + 'Posts/delete_post',
                            data: data,
                            type: 'POST',
                            success: function (postBack) {
                                var result = $.parseJSON(postBack);
//                    console.log(result);
                                if (result.msg == 1) {
                                    $(thisdialog).dialog("close");
                                    $($this).parents('.post-courage').remove();
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
//        report post
        $('.report-post').on('click', function () {
            var $this = $(this);
            $("#report-post-dialog").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Submit": function () {
                        var thisdialog = $(this);
                        var post = $this.attr('post');
                        var reportType = $('input[name="report-post"]:checked').val();
                        var data = 'post_id=' + post + '&type=' + reportType;
                        $.ajax({
                            url: window.base_url + 'Posts/report_post',
                            data: data,
                            type: 'POST',
                            success: function (postBack) {
//                    console.log(postBack);return;
                                var result = $.parseJSON(postBack);
                                if (result.msg == 1) {
                                    $(thisdialog).dialog("close");
                                    var msg = '<div class="alert alert-success  messages">Reported successfully.</div>';
                                    $(msg).appendTo('.messages-container');
                                    $('.messages-container').delay(3000).fadeOut();
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
        $('#del-posts').on('click', function () {
            var $this = $(this);
            var post = $(tihs).attr('post');
            var data = 'post=' + post;
            $.ajax({
                url: window.base_url + 'Posts/delete_post',
                data: data,
                type: 'POST',
                success: function (postBack) {
                    var result = $.parseJSON(postBack);
//                    console.log(result);
                    if (result.msg == 1) {
                        $($this).parents('.post-courage').remove();
                    }
                }
            });
        });
    });
	
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
	
</script>