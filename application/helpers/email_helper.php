<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function email_send($data) {

    
    $CI = get_instance();
    $config = $CI->config->load('email');
    
    $CI->load->library('email', $config);
    $CI->email->set_newline("\r\n");
    $CI->email->from($data['from'], $data['username']);
    $CI->email->to($data['to']);
    $CI->email->subject($data['subject']);
    $CI->email->message($data['message']);
    if ($CI->email->send()) {
        return TRUE;
    } else {
        print_r($CI->email->print_debugger());exit;
        return FALSE;
    }
}

function site_email($userData) {

    $email_title = config_item('howToUseSite');
    $templatesModel = model_load_model('templates_model');
    $where_template = array(
        'template_subject' => $email_title
    );
    $templateData = $templatesModel->get($where_template, $single = TRUE);
// @todo: there may be some changes in email of how to use site
//        $search = array(
//            'ID', 'TOKEN'
//        );
//        $replace = array(
//            $userData['user_id'], strtotime($userData['user_created'])
//        );
//        $templateBody = str_replace($search, $replace, $templateData['template_body']);
    $email_data = array(
        'from' => config_item('email_from'),
        'username' => $userData['user_firstname'],
        'subject' => $templateData['template_subject'],
        'message' => $templateData['template_body'],
        'to' => $userData['user_email']
    );
    $email_result = send_email($email_data);
    return $email_result;
}
