<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {

    public function index() {
        render_view('test.php');
    }

    public function profile_image() {

// Only accept files with these extensions
        $whitelist = array('jpg', 'jpeg', 'png');
        $name = null;
        $error = 'No file uploaded.';
        if (isset($_FILES)) {
            if (isset($_FILES['filesToUploadP'])) {
                $tmp_name = $_FILES['filesToUploadP']['tmp_name'];
                $orignal_name = explode('.', $_FILES['filesToUploadP']['name']);
                $ext = $orignal_name[count($orignal_name) - 1];                
                $name = ROOT_PATH.'/reellyou/assets/images/profile_images/'.time().'-'.rand(100, 10000).'.'.$ext;
                $error = $_FILES['filesToUploadP']['error'];

                if ($error === UPLOAD_ERR_OK) {
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    if (!in_array($extension, $whitelist)) {
                        $error = 'Invalid file type uploaded.';
                    } else {
                        move_uploaded_file($tmp_name, $name);
                        $mime = getimagesize($name);

                        $new_width = 550;
                        $new_height = 550;
                        if ($mime['mime'] == 'image/png') {
                            $src_img = imagecreatefrompng($name);
                        }
                        if ($mime['mime'] == 'image/jpg' || $mime['mime'] == 'image/jpeg' || $mime['mime'] == 'image/pjpeg') {
                            $src_img = imagecreatefromjpeg($name);
                        }

                        $old_x = imageSX($src_img);
                        $old_y = imageSY($src_img);

                        $thumb_w = $new_width;
                        $thumb_h = $old_y * ($new_height / $old_x);


                        $dst_img = ImageCreateTrueColor($thumb_w, $thumb_h);

                        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);


                        // New save location
                        $rand_file_name = time().'-'.rand(100, 10000).'.'.$ext;
                        $new_name = ROOT_PATH.'/reellyou/assets/images/profile_images/'.$rand_file_name;
                        $file_location = HTTP_HOST.'/assets/images/profile_images/'.$rand_file_name;

                        $new_thumb_loc = $new_name;

                        if ($mime['mime'] == 'image/png') {
                            $result = imagepng($dst_img, $new_thumb_loc, 8);
                        }
                        if ($mime['mime'] == 'image/jpg' || $mime['mime'] == 'image/jpeg' || $mime['mime'] == 'image/pjpeg') {
                            $result = imagejpeg($dst_img, $new_thumb_loc, 80);
                        }

                        @unlink($name);
                        imagedestroy($dst_img);
                        imagedestroy($src_img);
                    }
                }
            }
        }
        echo json_encode(array(
            'name' => $file_location,
            'error' => $error,
        ));
        die();
    }

    public function save_profile_image() {
        
        $targ_w = $targ_h = 180;
        $jpeg_quality = 90;

        $src_url = explode("/", $_POST['profilesrc']);
        
        $src = ROOT_PATH.'/reellyou/assets/images/profile_images/'.$src_url[count($src_url) - 1];
       
        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($targ_w, $targ_h);

        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $targ_w, $targ_h, $_POST['w'], $_POST['h']);

        $ext = explode('.', $src);
        $ext = $ext[count($ext) - 1];

        $actual_image_name1 = time().".".$ext;
        $target_file1 = ROOT_PATH.'/reellyou/assets/images/profile_images/';
        $resultSave = imagejpeg($dst_r, $target_file1.$actual_image_name1, $jpeg_quality);
        if($resultSave == TRUE){
            $this->session->set_flashdata('success','Image croped and saved successfully.');
        }else{
            $this->session->set_flashdata('error','Image processing failed.');
        }
            redirect(base_url());
    }

}

?>
