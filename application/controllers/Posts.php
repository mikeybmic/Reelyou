<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts extends CI_Controller {

//    var $profileModel = NULL;
//
//    function __construct() {
//
//        parent::__construct();
//        $this->profileModel = load_basic_model('profile');
//    }

    public function index() {
//        render_view('profile.php');
        redirect(base_url('Posts/my_reell'));
    }

    public function report_post() {

        $allPosts = $this->input->post(NULL, TRUE);
//        $data = array(
//            'post_id' => $allPosts['post_id'],
//            'type' => $allPosts['type']
//        );

        $model = load_basic_model('reported');
        $result = $model->insert($allPosts);
        if ($result > 0) {
            $postBack = array('msg' => 1);
        } else {
            $postBack = array('msg' => 0);
        }
        echo json_encode($postBack);
        exit;
    }
    public function delete_post() {
        $postId = $this->input->post('post');

        $model = load_basic_model('posts');
        $result = $model->delete(array('post_id' => $postId));
        if ($result > 0) {
            $postBack = array('msg' => 1);
        } else {
            $postBack = array('msg' => 0);
        }
        echo json_encode($postBack);
        exit;
    }
	
	public function pin_post() {
        $postId = $this->input->post('post');
		$data['post_pin']	=	1;
        $model = load_basic_model('posts');
		$unpost_data['post_pin']	=	0;
		$curUser = currentuser_session();
		
		$this->Profile_model->update_array(array('user_id' => $curUser['user_id']),'posts',$unpost_data);
		
		
		$this->Profile_model->update_array(array('post_id' => $postId),'posts',$data);
		$postBack = array('msg' => 1);
        echo json_encode($postBack);
        exit;
    }
	
	public function unpin_post() {
        $postId = $this->input->post('post');
		$data['post_pin']	=	0;
        $model = load_basic_model('posts');
		$this->Profile_model->update_array(array('post_id' => $postId),'posts',$data);
		$postBack = array('msg' => 1);
        echo json_encode($postBack);
        exit;
    }


    public function view_post() {
//        make tag seen
		$profile_model = model_load_model('profile_model');
        $postId = $this->input->get('id');
        $tagModel = load_basic_model('tag');
		$data['seen']	=	1;
        $curUser = currentuser_session();
		$this->Profile_model->update_array(array('user_id' => $curUser['user_id']),'tag_comments',$data);
        $model = model_load_model('Posts_model');
        $data['posts'] = $model->getPost($postId);
		$data['userData'] = $profile_model->getUserInfo($curUser['user_id']);
		
//        print_r($posts);exit;
        render_view('my-reell.php', $data);
    }

    public function my_reell() {
        $model = model_load_model('Posts_model');
        $data['posts'] = $model->getPosts();
//        print_r($posts);exit;
        render_view('my-reell.php', $data);
    }

    public function new_post() {
		
        render_view('new-post.php');
    }

    public function profile_image_change() {
        render_view('profile-image.php');
    }

    public function assesment() {
        $model = model_load_model('profile_model');
        $data['states'] = $model->getStates();
        render_view('assesment.php', $data);
    }

    public function upload_post() {
        $posts = $this->input->post(NULL, TRUE);
        $images = $posts['images'];
        $images = explode(',', $images);
        $title = $posts['title'];
        $type = $posts['type'];
//        $array = json_decode(json_encode($posts['data']), true);
//        print_r($posts);exit;
        $curUser = currentuser_session();
//        echo json_decode($posts);exit;
        $data = array('user_id' => $curUser['user_id'], 'title' => trim($title), 'post_type' => $posts['type']);
        $model = load_basic_model('posts');
        $result = $model->insert($data);
        $postId = $this->db->insert_id();
//        $postDataModel = load_basic_model('post_data');
        foreach ($images as $image) {
            $dataImages[] = array(
                'post_id' => $postId,
                'content' => $image
            );
        }
        $resultData = $this->db->insert_batch('post_data', $dataImages);
        if ($resultData > 0) {
            $return = array('msg' => '1');
        } else {
            $return = array('msg' => '0');
        }
        echo json_encode($return);
        exit;
    }

    public function getCities() {
        $stateId = $this->input->post('state');
        $model = model_load_model('profile_model');
        $data = $model->getCities($stateId);
        echo json_encode($data);
    }

    public function getZipCode() {

        $state = $this->input->post('state');
        $city = $this->input->post('city');

        $address = urlencode($city.",".$state.',US');
//$city = urlencode('San Francisco');

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyDPbWELH-0dOfRvNn9sm3NHcdCi4-5oUEA";

// Make the HTTP request
        $data = @file_get_contents($url);

// Parse the json response
        $jsondata = json_decode($data, true);
        $zipcode = $this->findLongName("postal_code", $jsondata["results"][0]["address_components"]);
        $zipcode = array('zip' => $zipcode);
        echo json_encode($zipcode);
    }

    public function findLongName($type, $array) {
        foreach ($array as $value) {
            if (in_array($type, $value["types"])) {
                return $value["long_name"];
            }
        }
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
                $name = ROOT_PATH.'/assets/images/profile_images/'.time().'-'.rand(100, 10000).'.'.$ext;
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
                        $new_name = ROOT_PATH.'/assets/images/profile_images/'.$rand_file_name;
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

        $src = ROOT_PATH.'/assets/images/profile_images/'.$src_url[count($src_url) - 1];

        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($_POST['w'], $_POST['h']);

        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'], $_POST['h']);

        $ext = explode('.', $src);
        $ext = $ext[count($ext) - 1];

        $actual_image_name1 = time().".".$ext;
        $target_file1 = ROOT_PATH.'/assets/images/profile_images/';
        $resultSave = imagejpeg($dst_r, $target_file1.$actual_image_name1, $jpeg_quality);
        if ($resultSave == TRUE) {
            unlink($src);
            $profileModel = load_basic_model('profile');

            $data = array('user_id' => $this->input->post('user'));
            $userInfo = $profileModel->get($data, 1);
            if (!empty($userInfo)) {
                unlink($target_file1.$userInfo['profile_image']);
                $data = array('profile_image' => $actual_image_name1);
                $where = array('user_id' => $this->input->post('user'));
                $profileModel->update($data, $where);
                $this->session->set_flashdata('success', 'Image updated successfully.');
            } else {
                $data = array('user_id' => $this->input->post('user'), 'profile_image' => $actual_image_name1);
                $profileModel->insert($data);
                $this->session->set_flashdata('success', 'Image cropped and saved successfully.');
            }
        } else {
            $this->session->set_flashdata('error', 'Image processing failed.');
        }
        redirect(base_url('Main'));
    }

    public function update_profile_desc() {
        $desc = $this->input->post('desc');
        $curUser = currentuser_session();

        $model = load_basic_model('profile');
        $resutlUp = $model->update(array('profile_desc' => $desc), array('user_id' => $curUser['user_id']));
        if ($resutlUp > 0) {
            $resut = array('msg' => 'success');
        } else {
            $resut = array('msg' => 'error');
        }
        echo json_encode($resut);
        exit;
    }

}

?>
