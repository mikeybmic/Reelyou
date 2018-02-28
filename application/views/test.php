<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * Load a view
 *
 * This is a substitute for the inability to load models
 * inside of other models in CodeIgniter.  Call it like
 * this:
 *
 * $view = view name relative to view folder;

 *
 */
function load_view($view_name, $view_data = null) {
    $CI = & get_instance();
    $CI->load->view($view_name, $view_data);
    //$temp = explode('/',$view_name);
    //$view_name = $temp[count($temp)-1];
    //return $CI->$view_name;
}

function render_view($view_name, $view_data = null, $header = null) {
    $CI = & get_instance();
    $CI->load->view('includes/header', $header);
    $CI->load->view($view_name, $view_data);
    $CI->load->view('includes/footer');
}

function get_post_data($post_id = null) {
    if ($post_id) {
        $CI = & get_instance();
        $CI->db->select('*');
        $CI->db->from('post_data');
        $CI->db->where('post_id', $post_id);
        $result = $CI->db->get()->result_array();
        return $result;
    } else {
        return false;
    }
}

function get_post_comments($postId) {
    $model = model_load_model('Posts_model');
    $userModel = load_basic_model('users');
    $comments = $model->getComments($postId, 0);
    
    $template = '';
    $template .= '<ul>';
    foreach ($comments as $i => $comment) {
        $userInfo = $userModel->get(array('user_id' => $comment['user_id']), 1);
        $template .= '<li id="'.$comment['comment_id'].'" class="comment-row">';
        $template .= $userInfo['first_name'].': ';
        $template .= $comment['comment_body'];
        $template .= '<span class="action-icons hidden"><span class="glyphicon glyphicon-share-alt  comment-reply" aria-hidden="true"></span>';
        $template .= '<span class="glyphicon glyphicon-remove comment-del" aria-hidden="true"></span></span>';

        $subComments = $model->getComments($comment['post_id'], $comment['comment_id']);
        if (!empty($subComments)) {
            $template .= '<ul>';
            foreach ($subComments as $i => $subComment) {
                $userInfo = $userModel->get(array('user_id' => $subComment['user_id']), 1);
                $template .= '<li id="'.$subComment['comment_id'].'" class="comment-row">';
                $template .= $userInfo['first_name'].': ';
                $template .= $subComment['comment_body'];
                $template .= '<span class="action-icons hidden"><span class="glyphicon glyphicon-share-alt  comment-reply" aria-hidden="true"></span>';
                $template .= '<span class="glyphicon glyphicon-remove comment-del" aria-hidden="true"></span></span>';
                $template .= '</li>';
            }
            $template .= '</ul>';
        }
        $template .= '</li>';
    }
    $template .= '</ul>';

    return $template;
}
