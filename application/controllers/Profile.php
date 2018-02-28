<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		
		check_session();
	}

    public function index() {
        render_view('profile.php');
    }

    public function user_profile($userID = false,$page=0) {

		$perPage = 5;
		$start = ceil($page *$perPage);
        $curUser = currentuser_session();

        if ($userID) {
            $userModel = model_load_model('User_model');
            $userID = $userID;
			$data['visitUserID'] = $userID;
            $relation = $userModel->check_relation($curUser['user_id'], $userID);
            $data['relation'] = $relation['confirm'];
        }
        else {
            $userID = $curUser['user_id'];
			$data['visitUserID'] = $userID;
        }

        $model = model_load_model('profile_model');
        $data['states'] = $model->getStates();
        $basicModel = load_basic_model('profile');
        $data['assesmentData'] = $basicModel->get(array('user_id' => $userID), 1);
        $postsModel = model_load_model('Posts_model');
        $data['posts'] = $postsModel->getUserPosts($userID,$start, $perPage);
        $data['profileData'] = $model->getUserInfo($userID);


        $data['userData'] = $model->getUserInfo($userID);






        render_view('profile', $data);
    }
	
	public function ajax_profile($userID,$page){
		$perPage = 5;
		$start = ceil($page *$perPage);
		$model = model_load_model('profile_model');
        $data['states'] = $model->getStates();
        $basicModel = load_basic_model('profile');
        $data['assesmentData'] = $basicModel->get(array('user_id' => $userID), 1);
        $postsModel = model_load_model('Posts_model');
        $data['posts'] = $postsModel->getUserPosts($userID,$start, $perPage);
        $data['profileData'] = $model->getUserInfo($userID);


        $data['userData'] = $model->getUserInfo($userID);	
		if ($this->input->is_ajax_request()) {
			
			if(count($data['posts'])>0){
			
		$this->load->view('ajax_content/profile_ajax.php', $data);
			}else{
			$data	=	1;
			echo $data;exit;	
			}
			
			
		}
		
		
	}

    public function timeline($page=0) {
		
		$perPage = 5;
		
		
		
		$start = ceil($page *$perPage);
		
		
        $curUser = currentuser_session();
        $userId = $curUser['user_id'];
//        if someone else profile
        if ($this->input->get('id')) {
            $userId = $this->input->get('id');
//            relation to current user
            $userModel = model_load_model('User_model');
            $relation = $userModel->check_relation($curUser['user_id'], $userId);
            $data['relation'] = $relation['confirm'];
        }
        else {

            $userId = $curUser['user_id'];
        }


        $model = model_load_model('profile_model');
        $data['states'] = $model->getStates();
        $basicModel = load_basic_model('profile');

        //POSTS
        $postsModel = model_load_model('Posts_model');
        $data['posts'] = $postsModel->getPosts_data($userId,$start, $perPage);

       $data['curuserData'] = $model->getUserInfo($userId);

        $data['curUserData'] = $model->getUserInfo($curUser['user_id']);
		
		if ($this->input->is_ajax_request()) {
			
			if(count($data['posts'])>0){
			
		$this->load->view('ajax_content/timeline_ajax.php', $data);
			}else{
			$data	=	1;
			echo $data;exit;	
			}
			
			
		}else{
			
        render_view('timeline.php', $data);
		
		}
    }

    public function activate_deactivate_account() {

        $userId = $this->input->get('id');

        $model = load_basic_model('users');

//        to reactivate
        if (!empty($userId)) {

            $updateResult_activation = $model->update(array('user_status' => '1'), array('user_id' => $userId));

            $result = $model->get(array('user_id' => $userId), 1);

            $currentUserData = array(
                'user_id' => $result['user_id'],
                'first_name' => $result['first_name'],
                'last_name' => $result['last_name'],
                'user_email' => $result['user_email'],
                'user_role' => $result['user_role']
            );

            $loggedIn = true;

            $session_data = array(
                "currentUser" => $currentUserData,
                'loggedIn' => $loggedIn
            );

            $this->session->set_userdata($session_data);
            $this->session->set_flashdata('success', 'Profile activated successully');
            redirect(base_url());
        }
        else {
            $curUser = currentuser_session();
            $updateResult_deactivate = $model->update(array('user_status' => '0'), array('user_id' => $curUser['user_id']));

            if ($updateResult_deactivate > 0) {
                echo 'update deactivate';
                exit;
//   EMAIL SENDING
                $email_title = config_item('account_activation');

                $emailModel = load_basic_model('email_templates');
                $where_template = array(
                    'template_title' => $email_title
                );

                $templateData = $emailModel->get($where_template, 1);

                $search = array(
                    'ACTIVATION-LINK'
                );
                $email = $curUser['user_email'];
                $link = base_url('Profile/activate_deactivate_account/?id='.$curUser['user_id']);

                $replace = array(
                    $link
                );
                $templateBody = str_replace($search, $replace, $templateData['template_body']);
                $email_data = array(
                    'from' => config_item('email_from'),
                    'username' => config_item('mailer_name'),
                    'subject' => $templateData['template_title'],
                    'message' => $templateBody,
                    'to' => $email
                );


// end email section
                $email_result = email_send($email_data);

                if ($email_result == TRUE) {
                    $this->session->set_flashdata('success', 'Profile deactivated successully.<br/> Email has been sent to activate your account.');
                }
                else {
                    $this->session->set_flashdata('success', 'Profile deactivated successully.<br/> But email sending failde, ask administrator to activate your account.');
                }

                redirect('Logout');
            }
            else if ($updateResult_deactivate < 1) {
                echo 'oye hoye';
                exit;
                $this->session->set_flashdata('error', 'Profile deactivation failed.');
                redirect(base_url('Main'));
            }
        }
    }

    public function my_reell() {
        $model = model_load_model('Posts_model');

        $data['posts'] = $model->getPosts();
//        print_r($posts);exit;
        render_view('my-reell.php', $data);
    }

    public function change_banner_image() {

        if (!array_filter($_FILES)) {
            redirect('Main');
        }
//        save image to server
        $config['upload_path'] = './assets/images/banner_images/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 2048;
        $config['max_width'] = 0;
        $config['max_height'] = 0;
        $config['overwrite'] = FALSE;
        $config['max_filename_increment'] = 100;
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('profile-banner')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata('error', $error);
            redirect(base_url('Main'));
        }
        else {
            $uploadeImage = array('upload_data' => $this->upload->data());

//            resize image

            $config2['image_library'] = 'gd2';
            $config2['source_image'] = $uploadeImage['upload_data']['full_path'];
            $config2['create_thumb'] = FALSE;
            $config2['maintain_ratio'] = FALSE;
            $config2['width'] = 818;
            $config2['height'] = 352;

            $this->load->library('image_lib');
            $this->image_lib->initialize($config2);

            $resizeResult = $this->image_lib->resize();
            if ($resizeResult == TRUE) {
                $curUser = currentuser_session();
                $profileModel = load_basic_model('profile');
                $data = array('profile_banner' => $uploadeImage['upload_data']['file_name']);
                $where = array('user_id' => $curUser['user_id']);
                $profileModel->update($data, $where);
                $this->session->set_flashdata('success', 'Banner image changed successfully.');
            }
            else {
                $this->session->set_flashdata('error', 'Image resizing failed.');
            }

            redirect(base_url('Main'));
        }
    }

    public function new_post() {
		$curUser = currentuser_session();
		$profile_model = model_load_model('profile_model');
		$data['userData'] = $profile_model->getUserInfo($curUser['user_id']);
        render_view('new-post.php', $data);
    }

    public function profile_image_change() {
        render_view('profile-image.php');
    }

    public function assesment() {

        $data['assesment'] = $this->session->userdata('assesment');
//        echo $data['assesment'];exit;
        if ($data['assesment'] == 0) {
            $this->session->set_flashdata('error', 'Please complete assesment first to complete your registration.');
        }
        $model = model_load_model('profile_model');
        $data['states'] = $model->getStates();
        $basicModel = load_basic_model('profile');
        $curUser = currentuser_session();
        $data['assesmentData'] = $basicModel->get(array('user_id' => $curUser['user_id']), 1);
        render_view('assesment.php', $data);
    }

    public function assesment_update() {
        $posts = $this->input->post(NULL, TRUE);

        $curUser = currentuser_session();
        
        $city   =   $this->Profile_model->get_signle_value(array('id'=>$posts['city']),'name','cities');
        $state  =   $this->Profile_model->get_signle_value(array('id'=>$posts['state']),'name','states');

        $address = $city.",".$state.',US';

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$address."&key=AIzaSyDPbWELH-0dOfRvNn9sm3NHcdCi4-5oUEA";
        
        $data = @file_get_contents($url);
        $jsondata = json_decode($data, true);
        
        $latLong = $jsondata["results"][0]["geometry"]['location'];
        $posts['lat'] = $latLong['lat'];
        $posts['long'] = $latLong['lng'];


        $model = load_basic_model('profile');
        $userData = $model->get(array('user_id' => $curUser['user_id']), 1);
//        print_r($posts);exit;
//        PROFILE IMAGE

        if (isset($_POST['profilesrc']) && $_POST['profilesrc'] != "" && isset($_POST['x']) && $_POST['x'] != "" && isset($_POST['y']) && isset($_POST['w']) && isset($_POST['h'])) {

            $previousProfileImage = FCPATH.'assets/images/profile_images/'.$userData['profile_image'];

            $targ_w = $targ_h = 180;
            $jpeg_quality = 90;

            $src_url = explode("/", $_POST['profilesrc']);

            $src = FCPATH.'assets/images/profile_images/'.$src_url[count($src_url) - 1];

            $img_r = imagecreatefromjpeg($src);
            $dst_r = ImageCreateTrueColor($_POST['w'], $_POST['h']);

            imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'], $_POST['h']);

            $ext = explode('.', $src);
            $ext = $ext[count($ext) - 1];

            $actual_image_name1 = time().".".$ext;
            $target_file1 = FCPATH.'assets/images/profile_images/';
            $resultSave = imagejpeg($dst_r, $target_file1.$actual_image_name1, $jpeg_quality);
            if ($resultSave == TRUE) {
                unlink($src);
                unlink($previousProfileImage);
                $posts['profile_image'] = $actual_image_name1;
            }
        }
        unset($posts['x'], $posts['y'], $posts['w'], $posts['h'], $posts['profilesrc'], $posts['user']);
//        END PROFILE IMAGE
//        print_r($posts);
//        exit;

        if (!empty($userData)) {
            $updateResult = $model->update($posts, array('user_id' => $curUser['user_id']));
            $error = $this->db->error();
//            echo $updateResult;exit;
        }
        else {
            $posts['user_id'] = $curUser['user_id'];
            $updateResult = $model->insert($posts);
        }
        if ($updateResult > 0 || $error['code'] == 0) {
            $userModel = load_basic_model('users');
            $assesmentResult = $userModel->update(array('assesment' => 1), array('user_id' => $curUser['user_id']));
//            if ($assesmentResult > 0) {
            $this->session->set_userdata('assesment', 1);
//            }
            $this->session->set_flashdata('success', 'Profile updated successully.');
        }
        else {
            $this->session->set_flashdata('error', 'Profile updation failed.');
        }
        redirect(base_url('profile/assesment'));
    }

    public function post_text() {
        $posts = $this->input->post(NULL, TRUE);
        $text = $posts['content'];
        $title = $posts['title'];
        $tagUsers = $posts['tagUser'];
//        remove duplicates
        $tagUsers = explode(',', $tagUsers);
        $tagUsers = array_unique($tagUsers);

        $curUser = currentuser_session();
//        echo json_decode($posts);exit;
        $data = array('user_id' => $curUser['user_id'], 'title' => trim($title), 'post_type' => '2');
        $model = load_basic_model('posts');
        $result = $model->insert($data);
        $postId = $this->db->insert_id();
        $data2 = array(
            'post_id' => $postId,
            'content' => $text
        );
        $datamodel = load_basic_model('post_data');
        $resultData = $datamodel->insert($data2);
        if ($resultData > 0) {
//   TAGING
            foreach ($tagUsers as $i => $userId) {
                $dataTag[] = array(
                    'post_id' => $postId,
                    'user_id' => $userId,
                );
            }
//           print_r($dataTag);exit;
            $tagModel = load_basic_model('tag');
            $tagModel->insert_batch($dataTag);
            $return = array('msg' => '1');
        }
        else {
            $return = array('msg' => '0');
        }
        echo json_encode($return);
        exit;
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
        }
        else {
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
                $name = FCPATH.'assets/images/profile_images/'.time().'-'.rand(100, 10000).'.'.$ext;
                $error = $_FILES['filesToUploadP']['error'];

                if ($error === UPLOAD_ERR_OK) {
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    if (!in_array($extension, $whitelist)) {
                        $error = 'Invalid file type uploaded.';
                    }
                    else {
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
                        $new_name = FCPATH.'assets/images/profile_images/'.$rand_file_name;
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

//
    public function save_profile_image() {

        $targ_w = $targ_h = 180;
        $jpeg_quality = 90;

        $src_url = explode("/", $_POST['profilesrc']);

        $src = FCPATH.'assets/images/profile_images/'.$src_url[count($src_url) - 1];

        $img_r = imagecreatefromjpeg($src);
        $dst_r = ImageCreateTrueColor($_POST['w'], $_POST['h']);

        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'], $_POST['h']);

        $ext = explode('.', $src);
        $ext = $ext[count($ext) - 1];

        $actual_image_name1 = time().".".$ext;
        $target_file1 = FCPATH.'assets/images/profile_images/';
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
            }
            else {
                $data = array('user_id' => $this->input->post('user'), 'profile_image' => $actual_image_name1);
                $profileModel->insert($data);
                $this->session->set_flashdata('success', 'Image cropped and saved successfully.');
            }
        }
        else {
            $this->session->set_flashdata('error', 'Image processing failed.');
        }
        redirect(base_url('Main'));
    }

    public function update_profile_desc() {
        $desc = $this->input->post('desc');
        if (empty($desc)) {
            $resut = array('msg' => 'error');
            echo json_encode($resut);
            exit;
        }
        $curUser = currentuser_session();

        $model = load_basic_model('profile');
        $resutlUp = $model->update(array('profile_desc' => $desc), array('user_id' => $curUser['user_id']));
        if ($resutlUp > 0) {
            $resut = array('msg' => 'success');
        }
        else {
            $resut = array('msg' => 'error');
        }
        echo json_encode($resut);
        exit;
    }

    public function setting() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('old_password', 'Old password', 'callback_check_validation');
		$this->form_validation->set_rules('email_address', 'Email address', 'trim|required|valid_email|callback_check_email');

        if ($this->form_validation->run() == false) {
			$curUser = currentuser_session();
			$data['profileData'] = $this->Profile_model->getUserInfo($curUser['user_id']);
            $data['assesment'] = $this->session->userdata('assesment');
            render_view('setting', $data);
        }
        else {


            if ($this->input->post('new_password') != '') {
                $data['password'] = md5($this->input->post('new_password'));
            }
            if ($this->input->post('user_status') != '') {

                $data['user_status'] = $this->input->post('user_status');
            }
			$data['user_email']		 =	$this->input->post('email_address');
            $curUser = currentuser_session();
            $this->Profile_model->common_update('users', 'user_id', $curUser['user_id'], $data);
            $this->session->set_userdata('sessionMessage', 'successfully updated the profile');
            redirect(base_url('Profile/setting'));
        }
    }

    function check_validation() {
        $this->load->library('form_validation');
        $old_password = md5($this->input->post('old_password'));
        $new_password = $this->input->post('new_password');
        $con_password = $this->input->post('con_password');
        $curUser = currentuser_session();

        $check = $this->Profile_model->select_where('user_id', 'users', array('user_id' => $curUser['user_id'], 'password' => $old_password))->num_rows();
        if ($con_password == '' && $new_password == '' && $old_password == '') {
            return TRUE;
        }
        else if ($con_password != $new_password) {

            $this->form_validation->set_message('check_validation', 'New and Confirm password are not match');
            return FALSE;
        }
        else if ($check == 0 && $con_password != '' && $new_password != '' && $old_password != '') {

            $this->form_validation->set_message('check_validation', 'You have enter incorrect old password');
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
	
	function check_email() {
        $this->load->library('form_validation');
        $email_address 		= $this->input->post('email_address');
        $oldemail_address   = $this->input->post('oldemail_address');
        $curUser = currentuser_session();
		if($oldemail_address==$email_address){
			return TRUE;
		}else{
		  $check = $this->Profile_model->select_where('user_id', 'users', array('user_email' => $email_address))->num_rows();	
		  
		  if($check>0){
			$this->form_validation->set_message('check_email', 'This email address already in use');
            return FALSE;  
		  }else{
			 return TRUE;  
		  }
			
		}
		
	
    }

    function edit_banner() {
        $curUser = currentuser_session();
        if (!empty($_FILES['banner_pic']['name'])) {

            $current_banner = $this->Profile_model->get_signle_value(array('user_id' => $curUser['user_id']), 'profile_banner', 'profile');
            $whitelist = array('jpg', 'jpeg', 'png');
            $tmp_name = $_FILES['banner_pic']['tmp_name'];
            $orignal_name = explode('.', $_FILES['banner_pic']['name']);
            $ext = $orignal_name[count($orignal_name) - 1];
            $randam_name = time().'-'.rand(100, 10000).'.'.$ext;
            $name = FCPATH.'assets/images/banner_images/'.$randam_name;
            $error = $_FILES['banner_pic']['error'];



            if ($error === UPLOAD_ERR_OK) {
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                if (!in_array($extension, $whitelist)) {
                    $error = 'Invalid file type uploaded.';

                    $resut = array('msg' => 'error', 'error' => 'Invalid File');
                    echo json_encode($resut);
                    exit;
                }
                else {

                    $image_info = getimagesize($_FILES["banner_pic"]["tmp_name"]);
                    $image_width = $image_info[0];
                    $image_height = $image_info[1];

                    if ($image_width < 820 || $image_height < 355) {

                        $resut = array('msg' => 'error', 'error' => 'File size must be greater than 820*355 dimension');
                        echo json_encode($resut);
                        exit;
                    }
                    else {

                        if (move_uploaded_file($tmp_name, $name)) {

                            if ($current_banner != '') {

                                if (file_exists(FCPATH.'assets/images/banner_images/'.$current_banner)) {
                                    unlink(FCPATH.'assets/images/banner_images/'.$current_banner);
                            }
                            }
                                $data['profile_banner'] = $randam_name;
                                $data['profile_desc'] = $this->input->post('profile_desc');
                                $this->Profile_model->common_update('profile', 'user_id', $curUser['user_id'], $data);
                                $resut = array('msg' => 'success', 'path' => base_url().'assets/images/banner_images/'.$randam_name);
                                echo json_encode($resut);
                                exit;
                            
                        }
                    }
                }
            }
        }
        else {
            $data['profile_desc'] = $this->input->post('profile_desc');
            $this->Profile_model->common_update('profile', 'user_id', $curUser['user_id'], $data);
            $resut = array('msg' => 'success', 'path' => 'empty');
            echo json_encode($resut);
            exit;
        }
    }

}

?>
