<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($userData);exit;
$curUser = currentuser_session();
$feeling = $curUser['feeling'];

require FCPATH. '/vendor/autoload.php';
		?>

<!--Content-->
<div class="profile-view-cont">

						<div class="row post-header">
                            <div class="col-sm-6">
                                <h3 class="name"><?php echo ucfirst ( $curuserData['first_name']).' '.ucfirst($curuserData['last_name']); ?></h3>
                            </div>
                            <div class="col-sm-6 text-right d-none">
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
                                <h3 class="blue-bg clearfix">TimeLine
                                <a class="pull-right" href="<?php echo base_url('Profile/new_post'); ?>">+ &nbsp;Create Post</a>
                                </h3>
                                 
                                
                             </div>
                         </div>
                        
        <style type="text/css">
  		.ajax-load{
  			background: #e1e1e1;
		    padding: 10px 0px;
		    width: 100%;
  		}
  	</style>                
    
    <div class="profile-detail" id="ajax_content">
        
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
//                $timestamp = (int) strtotime($post['created']);
                $postData = get_post_data($post['post_id']);
				$userData = $this->profile_model->getUserInfo($post['user_id']);
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
    </div>
</div>

<div class="ajax-load text-center" style="display:none">
	<p><img src="http://demo.itsolutionstuff.com/plugin/loader.gif">Loading More post</p>
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

<input type="hidden" name="num_rows" id="num_rows" value="0" />



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
	            url: window.base_url + 'Profile/timeline/'+ page,
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

    $('.comment-reply').on('click', function (e) {

//        $('.comment-box').parent('div').remove();
        var post = $(this).parents('.comments-box').attr('post-id');
        var parent = $(this).closest('.comment-row').attr('id');
        var commentBox = '<div class="row post_id_'+post+'"><form method="post" class="form-horizontal col-sm-6" action="">';
        commentBox += '<input type="text" name="comment"  class="form-control reply-input comment" placeholder="Your comment"/>';
        commentBox += '<input type="hidden" name="postId" value="' + post + '" class="form-control"/>';
        commentBox += '<input type="hidden" name="parent" value="' + parent + '" class="form-control"/>';
        commentBox += '</form></div>';
		$(".post_id_"+post).remove();
        $(commentBox).insertAfter($(this).closest('.comment-row'));
        $('.reply-input').focus();
    });

    //comment submit
    $(document).on('submit', 'form.comment-form', function (e) {
        e.preventDefault();
        var parentId = $('input[name="parent"]',this).val();
        var comment = $('.comment', this).val();
        var formData = $(this).serialize();
//        console.log(parentId);
//        return;par

        var tagUsers = [];
        $('input[name="tag-user[]"]').each(function () {
            tagUsers.push($(this).val());
        });


        if (comment.length == 0) {
            return false;
        }

        var splitData = formData.split('&');


        var commentId = splitData[2].split('=')[1];
        var data = formData + '&tagUser=' + tagUsers;
//        console.log(data);
//        return;
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
//                    console.log(appendToDiv);

                    if (parentId == 0) {
                        console.log('no');
//                            if (appendToDiv.firstElementChild == 'ul') {
                        $(result.comment).appendTo('.comments-box');
//                            } else {
//                                var commentsBox = '<ul>' + result.comment + '</ul>';
//                                $(commentsBox).appendTo(appendToDiv);
//                            }
                    } else {
                        console.log('how');
                        $(document).find('.comment-form').remove();
                        $(result.comment).appendTo($('#' + commentId));
                    }

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
                                $($this).parents('.chat-outer').remove();
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
                    $($this).parents('.chat-outer').remove();
                }
            }
        });
    });

    //        tag a friend
    $(document).on('keyup', '.comment', function (e) {
//            to submit only this form(
        $('form').removeClass('comment-form');
        $(this).parent('form').addClass('comment-form');
        var input = $(this).val();
//            console.log(input.substr(input.indexOf("@") + 1));
        if ($(this).val().indexOf('@') > -1) {
            $(this).autocomplete({
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
                    $(temp).appendTo($(this));
                    $(this).val(inputVal.concat(ui.item.name));
                }
            });
        }
    });


    //post cross show hide
    $('.comment-row').on('mouseover', function () {
        $(this).find('.comment-del').removeClass('hidden');
    }).on('mouseout', function () {
        $(this).find('.comment-del').addClass('hidden');
    });

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
	
	
	$(document).ready(function() {
		
	
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
