<?php
$url = $this->uri->segment_array();
$curUrl = end($url);
$activate_link = 'class="current"';

//profile image
$CI = get_instance();
$curUser = currentuser_session();
$userId = $curUser['user_id'];
$model = load_basic_model('profile');
$userData = $model->get(array('user_id' => $userId), 1);

////get new notifications
//$model = model_load_model('User_model');
//$notifications = $model->get_notifications($userId);
//
////TAGING
//$tagNotification = $model->get_tag_notifications();
//$tagCommentsNotification = $model->get_comments_tag_notifications();
?>
<div class="left-side-bar">
    <div class="logo">
        <a href="<?php echo base_url()?>profile/timeline"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="" title="">
        </a>
       <span>Inspire Reell</span> 
        
    </div>
    <div class="user-info">
        <div class="img"><a href="<?php echo base_url('Profile/assesment'); ?>"><img class="img-pp" width="49px" height="50px" src="<?php echo $img = (!empty($userData['profile_image'])) ? base_url()."assets/images/profile_images/".$userData['profile_image'] : base_url()."assets/images/profile_images/dummy-img.png" ?>" alt="" title=""></a></div>
        <div class="name"><?php echo $curUser['first_name'].' '.$curUser['last_name']; ?></div>
    </div>
    <nav>
        <ul>
            <li <?php echo ($curUrl == "timeline") ? $activate_link : ""; ?>>
                <a  href="<?php echo base_url('Profile/timeline'); ?>">
                    <div class="icon"><img src="<?php echo base_url(); ?>assets/images/clock-icon.png"></div>
                    Timeline
                </a>
            </li>
            <li <?php echo ($curUrl == "user_profile") ? $activate_link : ""; ?>>
                <a href="<?php echo base_url('Profile/user_profile'); ?>">
                    <div class="icon"><img src="<?php echo base_url(); ?>assets/images/profile-icon.png"></div>
                    Profile
                </a>
            </li>
            <li <?php echo ($curUrl == "get_connected") ? $activate_link : ""; ?>>
                <a href="<?php echo base_url('Main/get_connected'); ?>">
                    <div class="icon"><img src="<?php echo base_url(); ?>assets/images/connected-icon.png"></div>
                    Get Connected
                </a>
            </li>
            <li <?php echo ($curUrl == "inspiration_board") ? $activate_link : ""; ?>>
                <a href="<?php echo base_url('Main/inspiration_board'); ?>">
                    <div class="icon"><img src="<?php echo base_url(); ?>assets/images/board-icon.png"></div>
                    Inspiration Board
                </a>
            </li>
            
             <li <?php echo ($curUrl == "assesment") ? $activate_link : ""; ?>>
                <a href="<?php echo base_url('Profile/assesment'); ?>">
                    <div class="icon"><img src="<?php echo base_url(); ?>assets/images/accessment.png"></div>
                    Bio
                </a>
             </li>
             
             <li <?php echo ($curUrl == "setting") ? $activate_link : ""; ?>>
                <a href="<?php echo base_url('profile/setting'); ?>">
                    <div class="icon"><img src="<?php echo base_url(); ?>assets/images/setting-icon.png"></div>
                    Settings
                </a>
             </li>
            
        </ul>
    </nav>
</div>


<script type="text/javascript">
    $(document).ready(function () {

//        refresh left menu


       loadlink(); // This will run on page load
       setInterval(function () {
       loadlink() // this will run after every 5 seconds
      }, 10000);

//        confirm request

        $(document).on('click', '.reply-request', function (e) {
            e.preventDefault();
            var $this = $(this);
            var con = $(this).attr('con');
            var action = $(this).attr('action');
            var data = 'con=' + con + '&action=' + action;
//            console.log(data);return;
            $.ajax({
                type: 'POST',
                data: data,
                url: window.base_url + 'Users/process_request',
                success: function (postBack) {
//                    console.log(postBack);return;
//                    var data = $.parseJSON(postBack);
                    if (postBack == 1) {
                        $($this).parents('li').remove();
                    } else {
                        return false;
                    }
                }
            });

        });

//        new notifications toggle
        $(document).on('click', ".settings", function (e) {
            $(".tag-notification-detail").removeClass('visible');
            $(".notification-detail").removeClass('visible');
            $(".settings-menu").toggleClass('visible');
        });

//        new notifications toggle
        $(document).on('click', ".notification", function (e) {
            $(".notification-detail").removeClass('visible');
            $(".settings-menu").removeClass('visible');
            $(".tag-notification-detail").toggleClass('visible');
        });

//        new notifications toggle
        $(document).on('click', ".tagNotification", function (e) {
            $(".tag-notification-detail").removeClass('visible');
            $(".settings-menu").removeClass('visible');
            $(".notification-detail").toggleClass('visible');
        });

//        msg notifications toggle
        $(document).on('click', ".msg-notification", function (e) {
            $(".msg-notification-detail").toggleClass('visible');
            $(".settings-menu").removeClass('visible');
            $(".notification-detail").removeClass('visible');
        });

//search auto complete
        $(document).on('keyup ', '.search-user', function (e) {
            var searchUser = $(this).val();
            $(this).autocomplete({
                source: function (request, response) {
//                    console.log(response);
                    $.ajax({
                        url: window.base_url + 'Users/search_user',
                        dataType: "json",
                        data: {
                            value: searchUser
                        },
                        success: function (data) {
                            response($.map(data, function (item) {
//                                console.log(item.value);
                                return {
                                    value: item.value,
                                    image: item.image,
									id: item.id
                                };
                            }))
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    var val = ui.item.id;
                    window.location.href = window.base_url + "profile/user_profile/"+ val;
                }
            }).autocomplete("instance")._renderItem = function (ul, item) {
                return $("<li></li>")
                        .data("item.autocomplete", item)
                        .append("<img width='40px' src='"+item.image+"' />&nbsp;<a>" + item.value + "</a>")
                        .appendTo(ul);
            };
//            }
        });


    });
    function loadlink() {
//
       $('.left-side-notifications').load(window.base_url + 'Main/left_menu_notifications').fadeIn("slow");
   }

    //BIO POPUP

    $(document).on('click', '#bio-popup', function (e) {

        e.preventDefault();
        $('#bioModal').modal('show');
    })

    //BIO POPUP

    $(document).on('click', '#edit-banner', function (e) {

        e.preventDefault();
        $('#bannerModal').modal('show');
    })

    $(document).ready(function (e) {
		
		
		

        $('.openImgUpload').click(function () {
            $('#imgsupload').trigger('click');
        });


        $("#uploadForm").on('submit', (function (e) {

            var formData = new FormData(this);
            e.preventDefault();
            $.ajax({
                url: window.base_url + 'Profile/edit_banner',
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data)
                {
                    obj = JSON.parse(data);
                    $("#error-msg").empty();
                    if (obj.msg == 'success' && obj.path != 'empty') {
                        $("#change_section").html('<img src="' + obj.path + '" alt="" title="" width="100%" height="90%">');
                        $("#error-msg").html("<span style='color:red;'>successfully updated</p>");
						$("#ban_img").attr("src",obj.path);
						$("#pro_desc").html($('#profile_desc').val());
						
						
						
						
                    } else if (obj.msg == 'success' && obj.path == 'empty') {
                        $("#error-msg").html("<span style='color:red;'>successfully updated</p>");
                    } else {
                        $("#error-msg").html("<span style='color:red;'>" + obj.error + "</p>");
                    }
                },
                error: function ()
                {
                }
            });
        }));
    });

</script>
<style>

    .ui-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1000;
        float: left;
        display: none;
        min-width: 160px;   
        padding: 4px 0;
        margin: 0 0 10px 25px;
        list-style: none;
        background-color: #ccc;
        color:red;
        border-color: #ffffff;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;

        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;
    }
    .ui-menu-item{
        background-color: #ccc;
    }
    .ui-menu-item > a.ui-menu-item-wrapper {
        color: red;
        white-space: nowrap;
        text-decoration: none;
    }

    .ui-menu-item > a:hover,.ui-menu-item > img:hover{
        color: #ffffff;

    }

</style>