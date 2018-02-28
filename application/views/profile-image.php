<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$CI = & get_instance();
$curUser = currentuser_session();
?>
<!--Content-->
<div class="content">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="profile">
                    <div class="col-lg-3">
                        <?php load_view('includes/left-menu.php') ?>
                    </div>
                    <div class="col-lg-9">
                        <div class="profile-image">
                            <h2>Upload Profile Image</h2>
                            <form method="post" name="image-crop" action="<?php echo base_url('Profile/save_profile_image'); ?>" enctype="multipart/form-data">
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />
                                <input type="hidden" id="user" name="user" value="<?php echo $curUser['user_id'] ?>" />
                                <input type="hidden" id="profilesrc" name="profilesrc" value="" />
                                <div class="myProfileImage" style="display:none;"><img id="myProfileImage" alt=""></div>
                                <div class="clearfix"></div>
                                <input id="filesToUploadP" name="filesToUploadP" class="form-control" type="file">
                                <button class="next hidden" id="submit-btn" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.Jcrop.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jcrop/js/jquery.ajaxfileupload.js"></script>

<script>
    $("#filesToUploadP").AjaxFileUpload({

        action: '<?php echo base_url();?>Profile/profile_image',
        onComplete: function (filename, response) {
            $("#myProfileImage").attr('src', response.name);
            $(".myProfileImage").show();
            $("#profilesrc").val(response.name);
            $('#submit-btn').removeClass('hidden');
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

</script>