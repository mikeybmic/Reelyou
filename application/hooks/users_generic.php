<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users_generic {

    function chk_session() {

        $CI = & get_instance();

        if ($CI->router->class != "Login" && ($CI->router->class == "Main" && $CI->router->method != 'process_login') ) {

            $currentUser = $CI->session->userdata("currentUser");

            $currentUser['loggedIn'] = $CI->session->userdata("loggedIn");

//            print_r($currentUser);exit;
            if ($currentUser['loggedIn'] == TRUE) {

                return TRUE;
            } else {

                redirect(base_url());
            }
        }
    }

    function chk_assesment() {

        $CI = & get_instance();
//echo $CI->router->class;exit;
        $CI->session->set_userdata('assesment', 1);
        
        if ($CI->router->class == "logout" || $CI->router->class == "Logout") {

            $CI->session->sess_destroy();

            redirect(base_url());
        }

        if ($CI->router->class != "Login" && $CI->router->class != "Main" && $CI->router->method != 'assesment' && $CI->router->method != 'assesment_update' && $CI->router->method != 'getCities' && $CI->router->method != 'activate' && $CI->router->method != 'getZipCode' && $CI->router->method != 'process_login' && $CI->router->method != 'profile_image' && $CI->router->method != "forget_password" && $CI->router->method != "reactivate_link") {

            $CI->load->model('User_model', 'userModel');

            $userAssesment = $CI->userModel->getUserAssesment();

            if ($userAssesment['assesment'] == 1) {
                                
                return true;
                
            } else {

                $CI->session->set_userdata('assesment', 0);

                redirect('Profile/assesment');
            }
        }
    }

}
