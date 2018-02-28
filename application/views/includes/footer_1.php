<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$CI = & get_instance();
$curUser = currentuser_session();
if (array_filter($curUser)) {
    $model = load_basic_model('profile');
    $profileInfo = $model->get(array('user_id' => $curUser['user_id']), 1);
    if (isset($profileInfo['profile_image'])) {
        ?>
        <!---profile popup--->
        <div class="popup-box">
            <div id="bioModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><img src="<?php echo base_url(); ?>assets/images/cross-img.png" alt="" title=""></button>
                        </div>
                        <div class="modal-body">
                            <span>Michael Alli</span>
                            <img src="<?php echo base_url(); ?>assets/images/profile_images/<?php echo $profileInfo['profile_image']; ?>" alt="" title="">
                            <div class="edit">
                                <a href="#" id="edit-desc-btn"><img src="<?php echo base_url(); ?>assets/images/edit-img.png" alt="" title=""><span>Edit</span></a>
                                <div class="clear"></div>
                            </div>
                            <h6 class="edit-cont" id="bio-desc"><?php echo $profileInfo['profile_desc']; ?></h6>
                            <button class="done hide" id="confirm-bio-edit" type="button">Done</button> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---popup_End--->

    <?php }
} ?>
<!--Footer-->
<div id="awan"></div>

<!-- jQuery -->
<script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/jquery/js/jquery.validation.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/vendor/jquery.ui.widget.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo base_url(); ?>assets/jQuery-File-Upload/js/jquery.fileupload-validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/header.js"></script>


</body>
</html>
