<?php

function currentuser_session() {
    $CI = & get_instance();
    $currentUser = $CI->session->userdata("currentUser");
    $currentUser['loggedIn'] = $CI->session->userdata("loggedIn");
    return $currentUser;
}


function check_session() {

    $current_user = currentuser_session();

    $loggedIn = $current_user['loggedIn'];
    if ($loggedIn == TRUE) {
        return TRUE;
    } else {
        redirect(base_url());
    }
}

function check_admin_session() {

    $current_user = currentuser_session();

    if ($current_user != null && $current_user['user_type'] == 'admin') {
        return TRUE;
    } else {
        redirect(base_url() . 'admin/login?u=0');
    }
}

function check_session_status() {
    $current_user = currentuser_session();

    if ($current_user != null) {
        return TRUE;
    }else{
        return FALSE;
    }
}

?>
