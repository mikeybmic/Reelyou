<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

    public function index() {
        redirect('Main');
//  get user roles
        $roleModel = load_basic_model('user_roles');
        $viewData['userRoles'] = $roleModel->get();

//  get all users
        $genModel = model_load_model('generic_model');
        $viewData['users'] = $genModel->get_all_users();

        load_fullview('user_management_view', $viewData);
    }

    public function feeling() {
        $value = $this->input->post('value');
        if ($value == 'feeling-good')
            $feeling = '1';
        else if ($value == 'feeling-bad')
            $feeling = '0';
        $curUser = currentuser_session();
        $curUser['feeling'] = $feeling;
        $this->session->set_userdata('currentUser', $curUser);
        echo json_encode(array('feeling' => $feeling));
    }

    public function markers() {

        $usersModel = model_load_model('User_model');
        $profileData = $usersModel->getMarkers();
        $data = array();
        foreach ($profileData as $pd) {
            if(empty($pd['profile_image'])){
                $img = 'dummy-img.png';
            }else{
                $img = $pd['profile_image'];
            }
            $company = array();
            $company = array(
                'latitude' => (float) $pd['lat'],
                'longitude' => (float) $pd['long'],
                'name' => $pd['first_name'].' '.$pd['last_name'],
                'image' => $img,
                'city' => $pd['cityName'],
                'id' => $pd['user_id']
            );
            array_push($data, $company);
        }
        $a['markers'] = $data;
//print_r($data);exit;
        echo json_encode($a);
    }

//for autocomplete
    public function search_user() {

        $val = $this->input->post_get(NULL, TRUE);
        //print_r($val);
//        echo json_encode($val['value']);exit;
        //        if (empty($val))
//            return false;
        $userModel = model_load_model('User_model');
        $usersData = $userModel->search_user($val['value']);

        foreach ($usersData as $user) {
			
			if (file_exists(ROOT_PATH.'/assets/images/profile_images/'.$user['profile_image']) && $user['profile_image']!=''){
			$img = base_url().'/assets/images/profile_images/'.$user['profile_image'];	
				
			}else{
			$img = base_url().'/assets/images/profile_images/dummy-img.png';	
			}
			
            $item = array(
                'value' => $user['user_email'],
                'image' => $img,
                'name' => $user['first_name'].' '.$user['last_name'],
                'id' => $user['user_id']
            );
            $data[] = $item;
        }
        //print_r($data);
        echo json_encode($data);
        exit;
    }

//  when search button is clicked
    public function search_users() {

        $val = $this->input->post('search');
        if (empty($val))
            redirect('Main/get_connected');
        $userModel = model_load_model('User_model');
        $data['usersData'] = $userModel->search_users($val);

        $data['users'] = '';
        if (!empty($data['usersData'])) {
            $ids = '';
            foreach ($data['usersData'] as $user) {
                $ids[] = $user['user_id'];
            }
//        print_r($ids);exit;
            $ids = implode(', ', $ids);
            $curUser = currentuser_session();
            $userId = $curUser['user_id'];
            $data['users'] = $userModel->get_users_info(trim($ids), $userId);
        }
        render_view('get-connected.php', $data);
    }

    public function connect_to() {

        $friendId = $this->input->post('user');
        $model = load_basic_model('relations');
        $curUser = currentuser_session();
        $result = $model->insert(array('user_id' => $curUser['user_id'], 'friend_id' => $friendId, 'confirm' => '0'));
        if ($result > 0) {
            $postBack = array('msg' => 1);
        } else {
            $postBack = array('msg' => 0);
        }
        echo json_encode($postBack);
        exit;
    }

    public function unfriend() {

        $friendId = $this->input->post('user');
        $model = load_basic_model('relations');
        $curUser = currentuser_session();
        $result = $model->delete(array('user_id' => $curUser['user_id'], 'friend_id' => $friendId));
        if ($result > 0) {
            $postBack = array('msg' => 1);
        } else {
            $postBack = array('msg' => 0);
        }
        echo json_encode($postBack);
        exit;
    }

    public function process_request() {

        $posts = $this->input->post(NULL, TRUE);
        
        $basicModel = load_basic_model('relations');
        $curUser = currentuser_session();
        $where = array(
            'user_id' => $posts['con'],
            'friend_id' => $curUser['user_id']
        );
        if ($posts['action'] == 'confirm') {
            $data = array('confirm' => '1');
            $result = $basicModel->update($data);
        } else if ($posts['action'] == 'reject') {
            $result = $basicModel->delete($where);
        }
        echo $result;
        exit;
    }

    public function find_profile() {

        $val = $this->input->get('id');
        $userModel = model_load_model('User_model');
        $data['users'] = $userModel->get_user_info($val);
        render_view('get-connected.php', $data);
    }

    

    public function change_password_email() {

        if ($_REQUEST) {
            $userId = $this->input->get_post('id');
            $viewData['userId'] = $userId;
        } else {
            $viewData['userId'] = "";
        }
        load_fullview('change_password_email', $viewData);
    }

    public function change_password() {

        check_session();
        if ($_REQUEST) {
            $userId = $this->input->get_post('id');
            $viewData['userId'] = $userId;
        } else {
            $viewData['userId'] = "";
        }
        load_fullview('change_password_view', $viewData);
    }

    public function update_password() {

        check_session();
        if (isset($_POST['update-pw'])) {
            $curUser = currentuser_session();
            $userId = $curUser['user_id'];
            $userEmail = $curUser['user_email'];
            $curPassword = $this->input->post('old_password');
            $newPassword = $this->input->post('new_password');

            $basicModel = load_basic_model('users');
            $userData = $basicModel->get(array('user_id' => $userId), 1);
            if (md5($curPassword) == $userData['user_password']) {
                $data = array(
                    "user_password" => md5($newPassword)
                );
                $condition = array(
                    "user_id" => $userId
                );
                $affectdRow = $basicModel->update($data, $condition);
                if (count($affectdRow) > 0) {
                    $this->session->set_flashdata('success', 'Password updated successfully.');
                } else {
                    $this->session->set_flashdata('error', 'Some problem occured while updating password.');
                }
            } else {
                $this->session->set_flashdata('error', 'You have entered wrong password');
                redirect(base_url('users'));
            }
        } else {
            $this->session->set_flashdata('error', 'You are no through proper channel.');
            redirect(base_url('users'));
        }
    }

    public function user_profile() {
        check_session();
        $curUser = currentuser_session();
        $userId = $curUser['user_id'];
        $where = array('user_id' => $userId);
        $basicModel = load_basic_model('users');
        $viewData['userData'] = $basicModel->get($where, 1);
//  get user roles
        $roleModel = load_basic_model('user_roles');
        $viewData['userRoles'] = $roleModel->get();
        load_fullview('user_profile_view', $viewData);
    }

    public function add_user() {

        check_session();
        $allPost = $this->input->post(NULL, TRUE);

        $password = randomPassword();
        $allPost['user_password'] = md5($password);
        $allPost['created'] = time();

        $basicModel = load_basic_model('users');
        $result = $basicModel->insert($allPost);

// email section

        $email_title = config_item('registration');
        $emailModel = load_basic_model('email_templates');
        $where_template = array(
            'template_title' => $email_title
        );
        $templateData = $emailModel->get($where_template, 1);
        $search = array(
            'EMAIL', 'PASSWORD'
        );
        $email = $allPost['user_email'];

        $replace = array(
            $email, $password,
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

        if ($result > 0 && $email_result == TRUE)
            $this->session->set_flashdata('success', 'User inserted and email sent.');
        else if ($result > 0 && $email_result == FALSE)
            $this->session->set_flashdata('success', 'User inserted but email no sent.');
        else if ($result < 1 && $email_result == FALSE)
            $this->session->set_flashdata('error', 'Operation Failed.');

        redirect(base_url('users'));
    }

    public function edit_user() {

        check_session();
        $userId = $this->input->get_post('uid');
        $where = array('user_id' => $userId);
        $basicModel = load_basic_model('users');
        $viewData['userData'] = $basicModel->get($where, 1);

//  get user roles
        $roleModel = load_basic_model('user_roles');
        $viewData['userRoles'] = $roleModel->get();

        load_fullview('edit_user_view', $viewData);
    }

    public function update_user() {

        check_session();
        $post = $this->input->post(NULL, TRUE);
//        print_r($post);exit;
        $userId = $post['user_id'];
        $where = array('user_id' => $userId);
        unset($post['user_id']);
        if (isset($post['activate'])) {
            unset($post['activate']); //activate is not table field, so need to remove
            $post['user_status'] = 'active';
        }
        $basicModel = load_basic_model('users');
        $result = $basicModel->update($post, $where);
        if (count($result) > 0) {
            $this->session->set_flashdata('success', 'Operation successfully completed.');
        }
        $this->session->set_flashdata('redirectUri', base_url('users'));

//        redirect(base_url('users'));
    }

    public function remove_user() {
        $ids = $this->input->post('ids');
        $ids = explode(',', $ids);
        $basicModel = load_basic_model('users');
        foreach ($ids as $id) {
            $result = $basicModel->delete(array('user_id' => $id));
        }
        if (count($result) > 0) {
            $this->session->set_flashdata('success', 'Operation successfully completed.');
        }
        redirect(base_url('users'));
    }

    public function check_email() {

        $email = $this->input->post('email');
        $basicModel = load_basic_model('users');
        $data = $basicModel->get(array('user_email' => $email), 1);
        if (count($data) > 0) {
            $result = array('msg' => 'exist');
        } else {
            $result = array('msg' => 'ok');
        }
        echo json_encode($result);
    }

}
