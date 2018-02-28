<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($profileData);exit;
$this->load->helper('date');
$postsModel = model_load_model('Posts_model');

//profile image
$CI = get_instance();
$curUser = currentuser_session();
//print_r($curUser);exit;
$userId = $curUser['user_id'];
$model = load_basic_model('profile');
$userData = $model->get(array('user_id' => $userId), 1);
?>
<!--Content-->
<div id="tabs" class="tabs-inline">
    <ul class="list-inline nav-tabs">
        <li ><a href="#success-timeline">Success Timeline</a></li>
        <li><a href="#recent-activities" role="tab" data-toggle="tab">Recent Activities</a></li>
        <li><a href="#Connections">Connections</a></li>

    </ul>
    <!-- Tab panes -->
    <div  id="success-timeline">
        <!--<div class="col-sm-12">-->
            <div class="row">
                <div class="profile-cont">
                    <div class="profile-header">
                        <h3><?php echo $curUser['first_name'].' '.$curUser['last_name']; ?></h3>
                        <?php load_view('feeling.php'); ?>
                        <div class="clear"></div>
                    </div>
                    <div class="creat-post">
                        <h2>My Reell</h2>
                        <a class="reat" href="<?php echo base_url('Profile/new_post'); ?>">+ &nbsp;Create Post</a>
                        <div class="clear"></div>
                    </div>

                    <?php
                    if (!empty($posts)) {
                        foreach ($posts as $post) {
                            $timestamp = (int) strtotime($post['created']);
                            $postData = get_post_data($post['post_id']);
                            ?>
                    <hr>
                            <div class="post-courage">
                                <input type="hidden" name="post-id" value="<?php echo $post['post_id']; ?>"/>
                                <!-- action list -->

                                <div class="btn-group float-right profile-action-dropdown">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                        <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                    </ul>
                                </div>


                                <h4><?php echo $post['title']; ?></h4>
                                <?php if ($post['post_type'] == 1) { ?>
                                
                                    <div class="row text-center">
                                        <ul>
                                            <?php
                                            foreach ($postData as $image) {
                                                if (file_exists(ROOT_PATH.'/assets/images/post_images/thumbnail/'.$image['content'])) {
                                                    $imgSize = getimagesize(ROOT_PATH.'/assets/images/post_images/thumbnail/'.$image['content']);
//                                                                                                echo '<pre>';
//                                                                                                print_r($imgSize);

                                                    if ($imgSize[0] > $imgSize[1]) {
                                                        ?>
                                                        <li class="small-img" data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/<?php echo $image['content']; ?>"><img src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/<?php echo $image['content']; ?>" alt="" title=""></li>
                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <li class="large-img" data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/<?php echo $image['content']; ?>"><img src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/<?php echo $image['content']; ?>" alt="" title=""></li>
                                                    <?php } /* <div class="col-sm-2">
                                                      <a data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/<?php echo $image['content']; ?>"><img class="col-sm-12" src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/<?php echo $image['content']; ?>" alt=""/></a>
                                                      </div> */ ?>
                                                    <?php
                                                }
                                                else {
                                                    if (file_exists(ROOT_PATH.'/assets/images/post_images/'.$image['content'])) {
                                                        ?>
                                                        <li class="small-img" data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/<?php echo $image['content']; ?>"><img src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/dummy.png" alt="" title=""></li>
                                                        <?php
                                                    }
                                                    else {
                                                        ?>
                                                        <li class="small-img" data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo base_url(); ?>assets/images/post_images/dummy.png"><img src="<?php echo base_url(); ?>assets/images/post_images/thumbnail/dummy.png" alt="" title=""></li>

                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                else if ($post['post_type'] == 2) {
                                    ?>
                                    <div class=""><?php echo $postData[0]['content']; ?></div>
                                <?php } ?>
                                <div class="row marginTop10 action-row">
                                    <!--<div class="comment col-sm-7"><a href="#"><span class="glyphicon glyphicon-comment" aria-hidden="true">Comment</span></a></div>-->
                                    <div class="col-sm-5 float-right"><h5 class="font9"><?php echo timespan($timestamp, (int) time(), 7); ?> ago</h5></div>
                                </div>
                                <div class="row comments-box">

                                    <?php echo $comments = get_post_comments($post['post_id'], 0); ?>
                                </div>

                            </div>
                            <?php
                        }
                    }
                    else {
                        ?>
                        <div>You don't have any post yet.</div>
                    <?php }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        <!--</div>--> 
    </div>

    <div id="recent-activities">
        <?php foreach ($recentActivities as $ra) { ?>
            <div class="thumbnail-img">
                <a href="<?php echo base_url("Posts/view_post?id=".$ra['post_id']); ?>">
                    <img  src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo ($ra['profile_image']) ? $ra['profile_image'] : 'dummy-img.png'; ?>" alt="" title="">
                    <h5><?php echo substr($ra['first_name'], 0, 10); ?></h5>
                </a>
            </div>
        <?php } ?>
    </div>

    <div id="Connections">
        <div class="conection-profile">
            <?php
            if ($users) {

                foreach ($users as $user_info) {
                    ?>
                    <div class="conection-box">
                        <div class="conection-image">
                            <img src="<?php echo $img = (!empty($user_info['profile_image'])) ? base_url()."assets/images/profile_images/".$user_info['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title="">
                        </div>
                        <div class="conection-name"><?php echo $user_info['first_name'].' '.$user_info['last_name']; ?></div>
                        <a href="#" class="message-btn">Send Message</a>
                    </div>
                    <?php
                }
            }
            else {
                echo "<div>No friends.</div>";
            }
            ?>



        </div>
    </div>

</div>

<!--banner change dialog-->
<div class="hidden">
    <div id="change-banner-dialog" title="Update Cover Image">
        <form method="post" action="<?php echo base_url('Profile/change_banner_image'); ?>"  id="change-banner-form" enctype="multipart/form-data">
            <input type="file" name="profile-banner" id="profile-banner" required=""/>
            <span>Image must not be less than 820*355</span>
        </form>
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



<div class="popup-box hidden">
    <div id="bannerModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo base_url(); ?>assets/<?php echo base_url(); ?>assets/images/cross-img.png" alt="" title=""></button>
                </div>
                <div class="modal-body">
                    <div id="change_section">
                        <img src="assets/<?php echo base_url(); ?>assets/images/banner_<?php echo base_url(); ?>assets/images/<?php echo (!empty($profileData['profile_banner'])) ? $profileData['profile_banner'] : 'profile-banner.png'; ?>" alt="" title="" width="100%" height="90%">
                    </div>


                    <form id="uploadForm" method="post" action="" enctype="multipart/form-data">
                        <div class="edit banner-popup">


                            <a href="#" ><img class="openImgUpload" src="<?php echo base_url(); ?>assets/<?php echo base_url(); ?>assets/images/edit-img.png" alt="" title=""><span class="openImgUpload">Edit</span>

                            </a>
                            <input type="file" id="imgsupload" name="banner_pic" style="display:none"/>
                            <div id="error-msg"></div>

                            <div class="clear"></div>



                        </div>


                        <h6><textarea class="form-control" maxlength="140" rows="3" name="profile_desc" required=""><?php echo $profileData['profile_desc']; ?></textarea></h6>

                        <button class="done" id="edit_banner" type="submit">Done</button>
                    </form> 
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
//banner change
        $('#change-banner').on('click', function () {
            $("#change-banner-dialog").dialog({
                resizable: false,
                height: "auto",
                width: 400,
                modal: true,
                buttons: {
                    "Yes": function () {
                        $("#change-banner-form").submit();
                    },
                    Cancel: function () {
                        $(this).dialog("close");
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
                        $($this).text('Connect').removeClass('un-friend').addClass('connect-to').css('background', '#80befc');
                    } else {
                        return false;
                    }
                }
            });

        });


    });
</script>        


