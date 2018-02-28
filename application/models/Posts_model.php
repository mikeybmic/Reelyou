<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Posts_model extends CI_Model {

    public function getComments($postId, $parentId) {
       
        $curUser = currentuser_session();
        $this->db->select('*');
        $this->db->from('comments');
//        $this->db->where('user_id', $curUser['user_id']);; 
        $this->db->where('post_id', $postId);
        $this->db->where('parent_id', $parentId);
        $this->db->order_by('created', 'ASC');
        $result = $this->db->get()->result_array();
//            if($parentId != 0){
//                print_r($result);exit;
//    }
        return $result;
    }

    public function getSubComments($postId, $parentId) {
        $curUser = currentuser_session();
        $this->db->select('*');
        $this->db->from('comments');
        $this->db->where('user_id', $curUser['user_id']);
        $this->db->where('post_id', $postId);
        $this->db->where('parent_id', $parentId);
        $this->db->order_by('created', 'ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }
	
	public function getUserPosts($userID,$start, $perPage) {
         $sql	=	"SELECT * from posts where user_id=".$userID." order by post_pin DESC,created DESC LIMIT ".$perPage." OFFSET ".$start."";
         $result =$this->db->query($sql);
         $result = $result->result_array();
		 return $result;
    }
	
	public function getPosts($userId) {
        
        $this->db->select('*');
        $this->db->from('posts');
        $this->db->where('user_id', $userId);
		$this->db->order_by('post_pin', 'DESC');
        $this->db->order_by('created', 'DESC');
        $result = $this->db->get()->result_array();
        return $result;
    }


    public function getPosts_data($userId,$start, $perPage) {
        $sql	=	"SELECT * from posts where user_id IN(select user_id from relations where (user_id=".$userId." or friend_id=".$userId.") and confirm='1' UNION SELECT friend_id from relations where (friend_id=".$userId." or user_id=".$userId.") and confirm='1') order by post_pin DESC,created DESC LIMIT ".$perPage." OFFSET ".$start."";
		 $result =$this->db->query($sql);
         $result = $result->result_array();

        return $result;
    }

    public function getPost($post_id) {
        $curUser = currentuser_session();
        $this->db->select('*');
        $this->db->from('posts');
//        $this->db->where('user_id', $curUser['user_id']);
        $this->db->where('post_id', $post_id);
        $result = $this->db->get()->result_array();
        return $result;
    }

}
