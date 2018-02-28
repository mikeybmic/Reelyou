<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($userData);exit;
$curUser = currentuser_session();
?>

<!--Content-->
<div class="profile-view-cont">
    <div class="banner-img">
        <img src="<?php echo base_url() ?>assets/images/banner_images/<?php echo $userData['profile_banner']; ?>" alt="" title="">
    </div>
    <div class="profile-detail">
        <div class="profile-line">
            <div class="profile-img"><img src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
            <h2><?php echo $userData['first_name'].' '.$userData['last_name']; ?></h2>
            <?php if ($userData['user_id'] != $curUser['user_id']) { ?>
                <?php if ($relation == '1') { ?>
                    <a href="javascript:void(0)" user="<?php echo $userData['user_id']; ?>" class="un-friend" >Unfriend</a>
                    <?php
                }
                else if ($relation == '0') {
                    ?>
                    <a href="javascript:void(0)" user="<?php echo $userData['user_id']; ?>" class="un-friend">Cancel Request</a>
                    <?php
                }
                else {
                    ?>
                    <a href="javascript:void(0)" user="<?php echo $userData['user_id']; ?>" class="connect-to add-friend">Add Friend</a>
                <?php } ?>

            <?php } ?>
        </div>
        <div class="profile-line">
            <p>
                <?php echo $userData['profile_desc'] ?> 
            </p>
        </div>
        <?php if ($userData['user_id'] != $curUser['user_id']) { ?>
            <div class="small-info">
                <div class="info-line">State: <span><?php echo $userData['state']; ?></span></div>
                <div class="info-line">City: <span><?php echo $userData['city']; ?></span></div>
                <div class="info-line"><img src="<?php echo base_url() ?>assets/images/music-image.png" alt="" title="">  <?php echo $userData['interest']; ?></div>
            </div>
        <?php } ?>
        <div class="timeline-outer">
            <div class="title-text">Timeline</div>
            <div class="time-line-cont">
                <div class="fill"></div>
            </div>
        </div>
        <?php
        if (!empty($posts)) {
            foreach ($posts as $post) {
//                $timestamp = (int) strtotime($post['created']);
                $postData = get_post_data($post['post_id']);
                if ($post['post_type'] == 1) {
                    ?>

                    <div class="chat-outer">
                        <div class="chat-box">
                            <div class="chat-box-upper">
                                <div class="chat-popup">

                                    <!--actions buttons-->
                                    <div class="btn-group float-right profile-action-dropdown">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                        </ul>
                                    </div>
                                    <!--actions buttons-->

                                    <h3><?php echo $post['title']; ?></h3>
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
                                    <div class="like-row">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/like-image.png" alt="" title=""> Like</a>
                                        <a href="#">Reply</a>
                                    </div>

                                    <!--COMMENTS-->
                                    <div class="row comments-box" post-id="<?php echo $post['post_id']; ?>">
                                        <?php echo $comments = get_post_comments($post['post_id'], 0); ?>
                                    </div>
                                    <!--END COMMENTS-->

                                    <!--write a comment-->
                                    <div>
                                        <form method="post" class="form-horizontal" action="">
                                            <input type="text" name="comment"  class="form-control comment" placeholder="Your comment"/>
                                            <input type="hidden" name="postId" value="<?php echo $post['post_id']; ?>" class="form-control"/>
                                            <input type="hidden" name="parent" value="0" class="form-control"/>
                                        </form>
                                    </div>
                                </div>
                                <div class="bottom-arrow"><img src="<?php echo base_url() ?>assets/images/chat-arrow.png" alt="" title=""></div>
                            </div>
                            <div class="chat-box-bottom">
                                <div class="avatar-img"><img src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
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
                            <div class="chat-box-upper">
                                <div class="chat-popup">
                                    <h3><?php echo $post['title']; ?></h3>
                                    <div class="chat-content">
                                        <?php foreach ($postData as $image) { ?>
                                            <img data-fancybox="<?php echo $post['post_id']; ?>" href="<?php echo $image['content']; ?>" src="<?php echo $image['content']; ?>" alt="" title="">

                                        <?php }
                                        ?>
                                    </div>
                                    <div class="like-row">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/like-image.png" alt="" title=""> Like</a>
                                        <a href="#">Reply</a>
                                    </div>

                                    <!--COMMENTS-->
                                    <div class="row comments-box" post-id="<?php echo $post['post_id']; ?>">
                                        <?php echo $comments = get_post_comments($post['post_id'], 0); ?>
                                    </div>
                                    <!--END COMMENTS-->
                                </div>
                                <div class="bottom-arrow"><img src="<?php echo base_url() ?>assets/images/chat-arrow.png" alt="" title=""></div>
                            </div>
                            <div class="chat-box-bottom">
                                <div class="avatar-img"><img src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
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
                            <div class="chat-box-upper">
                                <div class="chat-popup">
                                    <!--actions buttons-->
                                    <div class="btn-group float-right profile-action-dropdown">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" >
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="javascript:void(0)" class="del-post" post="<?php echo $post['post_id']; ?>">Delete</a></li>
                                            <li><a href="javascript:void(0)" class="report-post" post="<?php echo $post['post_id']; ?>">Report</a></li>
                                        </ul>
                                    </div>
                                    <!--actions buttons--> 
                                    <h3><?php echo $post['title']; ?></h3>
                                    <div class="chat-content">
                                    </div>
                                    <div class="like-row">
                                        <a href="#"><img src="<?php echo base_url() ?>assets/images/like-image.png" alt="" title=""> Like</a>
                                        <a href="#">Reply</a>
                                    </div>
                                    <div class="reply-cont">
                                        <div class="avatar-small"><img src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $curUserData['profile_image']; ?>" alt="" title=""></div>
                                        <div class="reply-field">
                                            <div class="row comments-box" post-id="<?php echo $post['post_id']; ?>">

                                                <?php echo $comments = get_post_comments($post['post_id'], 0); ?>
                                            </div>
                                            <!--write a comment-->
                                            <form method="post" class="form-horizontal" action="">
                                                <input type="text" name="comment"  class="form-control comment" placeholder="Your comment"/>
                                                <input type="hidden" name="postId" value="<?php echo $post['post_id']; ?>" class="form-control"/>
                                                <input type="hidden" name="parent" value="0" class="form-control"/>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="bottom-arrow"><img src="<?php echo base_url() ?>assets/images/chat-arrow.png" alt="" title=""></div>
                            </div>
                            <div class="chat-box-bottom">
                                <div class="avatar-img"><img src="<?php echo base_url() ?>assets/images/profile_images/<?php echo $userData['profile_image']; ?>" alt="" title=""></div>
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
        var commentBox = '<div class="row"><form method="post" class="form-horizontal col-sm-6" action="">';
        commentBox += '<input type="text" name="comment"  class="form-control reply-input comment" placeholder="Your comment"/>';
        commentBox += '<input type="hidden" name="postId" value="' + post + '" class="form-control"/>';
        commentBox += '<input type="hidden" name="parent" value="' + parent + '" class="form-control"/>';
        commentBox += '</form></div>';
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
</script>
