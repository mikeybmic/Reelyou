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


function comments_template($comment) {
    $userModel = load_basic_model('users');
    $profileModel = model_load_model('Profile_model');
    $userInfo = $profileModel->getUserInfo($comment['user_id']);
    //
    $template = '<div class="comment-row" id="'.$comment['comment_id'].'">';
    $template .= '<a class="delete comment-del hidden" href="javascript:void(0)" >x</a>';
    $template .= '<div class="profile-img">';
    $template .= '<img src="'.base_url().'assets/images/profile_images/'.$userInfo['profile_image'].'" alt="" title="">';
    $template .= '</div>';
    $template .= '<div class="block-content">';
    $template .= '<a href="javascript:void(0)">'.$userInfo['first_name'].':</a>';
    $template .= '<span>'.$comment['comment_body'].'</span>';
    $template .= '<ul>';
//    $template .= '<li><img src="'.base_url().'assets/images/like-img2.png" alt="" title=""><a href="javascript:void(0)">Like</a></li>';
    $template .= '<li>';
    $template .= '<a href="javascript:void(0)" class="comment-reply">Reply</a>';
    $template .= '<div style="clear:both"></div>';
    $template .= '</ul>';
    $template .= '</div>';
    $template .= '<div style="clear:both"></div>';


    return $template;
}

function get_post_comments($postId, $parentId) {

    $temp = '';
    $model = model_load_model('Posts_model');


    $comments = $model->getComments($postId, $parentId);

    $template = '';
    foreach ($comments as $i => $comment) {
        $template .= comments_template($comment);
        $subComments = $model->getComments($comment['post_id'], $comment['comment_id']);
        //if($is_rec){echo '<pre>';print_r($subComments);exit;}
        if (!empty($subComments)) {
            foreach ($subComments as $i => $subComment) {
                $template .= comments_template($subComment);
                $subCommentsSub = $model->getComments($comment['post_id'], $subComment['comment_id']);

                if (!empty($subCommentsSub)) {
                    $template .= get_post_comments($comment['post_id'], $subComment['comment_id']);
                }
                $template .= '</div>';
            }
        }

        $template .= '</div>';
    }
    return $template;
}
