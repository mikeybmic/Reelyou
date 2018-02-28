<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public $model;
    public $curUser;

    function __construct() {
        parent::__construct();
		check_session();
        $this->model = load_basic_model('comments');
        $this->curUser = currentuser_session();
    }

    public function index() {
        $model = model_load_model('Profile_model');
        $data['profileData'] = $model->getUserInfo($this->curUser['user_id']);
        render_view('profile', $data);
    }

    public function delete_comment() {
        $commentId = $this->input->post('comment');
		
		$user_id	=	$this->Profile_model->get_signle_value(array('cid'=>$commentId),'user_id','comment');
		if($user_id ==$this->curUser['user_id']){
		
		$cid	=	$this->Profile_model->get_signle_value(array('cid'=>$commentId),'parent','comment');
		
		$result = $this->Profile_model->delete_where(array('parent' => $commentId),'comment');
        $result =   $this->Profile_model->delete_where(array('cid' => $commentId),'comment');
		
		
        if ($result>0) {
            
			
			$result = $this->Profile_model->select_where('*','comment',array('parent'=>$cid))->num_rows();
			if($result==0){	
					
			$array['children']	=	0;
			$this->Profile_model->common_update('comment','cid',$cid,$array);
				
			}
			
            $postBack = array('msg' => 1);
        } else {
            $postBack = array('msg' => 0);
        }
        echo json_encode($postBack);
        exit;
		}else{
			$postBack = array('msg' => 0,'error'=>'UserID not match');
			echo json_encode($postBack);
			exit;
			
		}
    }
	
	
	public function like_post() {
        $post_id = $this->input->post('post_id');
		$user_id = $this->curUser['user_id'];
		
		$total_post = $this->Profile_model->select_where('*','post_like',array('user_id'=>$user_id,'post_id'=>$post_id))->num_rows();
		
		if($total_post==0){
		$data['user_id']	=	$user_id;
		$data['post_id']	=	$post_id;
		$this->Profile_model->insert_array('post_like',$data);
		$total_like = $this->Profile_model->select_where('*','post_like',array('post_id'=>$post_id))->num_rows();
		$postBack = array('success'=>1,'imgsrc' =>base_url().'assets/images/like-img.png','type'=>'like','total_like'=>$total_like);	
			
		}else{
		$this->Profile_model->delete_where(array('user_id' => $user_id,'post_id'=>$post_id),'post_like');
		$total_like = $this->Profile_model->select_where('*','post_like',array('post_id'=>$post_id))->num_rows();
		$postBack = array('success'=>1,'imgsrc' =>base_url().'assets/images/like-image.png','type'=>'unlike','total_like'=>$total_like);	
		
			
		}
		
		echo json_encode($postBack);
        exit;
       
    }
	
	
	
	
	
	
	public function inset_comment(){
	require FCPATH. '/vendor/autoload.php';

	if ( isset($_POST['msg'], $_POST['parent'], $_POST['post_id']) ) {

	$post_id = (int) $_POST['post_id'];
	$msg = trim($_POST['msg']);
	
	if ( empty($_POST['parent']) ) {
		$parent = null;
	}
	else {
		
		$parent	=	explode('-',$_POST['parent']);
		
		if(count($parent)>1){
		$parent	=	$parent[1];
		}else{
		$parent = (int) $_POST['parent'];
		}
		
	}
	
	$user_id = $this->curUser['user_id'];
	
	$status_msg = array();
	
	// Author surname must be empty, is supposed to be filled only by bots
	if ( (!empty($msg) || $msg === '0') ) {
		
		// Validate comment length
		if ( Validation::len($msg, 255, 1) !== true ) {
			$status_msg[] = 'Your comment cannot exceed 255 characters';
		}
	
		// Validate parent sid
		if ( Validation::sid($post_id) !== true ) {
			$status_msg[] = 'Invalid section ID';
		}
		
		// Validate parent id
		if ( Validation::parent($parent) !== true ) {
			$status_msg[] = 'Invalid parent ID';
		}
		
		// If all user provided data is valid and trimmed
		if ( $status_msg === array() ) {
		
			$comment_handler = new CommentHandler();
			
			$data['post_id']	=	$post_id;
			$data['message']	=	$msg;
			$data['parent']	=	$parent;
			$data['user_id']	=	$user_id;
			
			// Insert the comment
			if ( ( $cid = $this->Profile_model->insert_array('comment',$data)) !== false ) {
				
				if ($parent !== 'NULL') {
					
				$child_data['children']	=	1;
				$this->Profile_model->common_update('comment','cid',$parent,$child_data);
				
				$tag_comment['cid']		=	$cid;
				$tag_comment['user_id']	=	$this->Profile_model->get_signle_value(array('post_id'=>$post_id),'user_id','posts');
				$tag_comment['seen']	=	0;
				
				if($user_id!=$tag_comment['user_id']){
					
				$this->Profile_model->insert_array('tag_comments',$tag_comment);
				
				}
				
				$profile_pic	=	$this->Profile_model->get_signle_value(array('user_id'=>$user_id),'profile_image','profile');
				
				
				$response = array (
					'status_code' => 0,
					'message_id' => $cid,
					'profile_image' => base_url().'assets/images/profile_images/'.$profile_pic
				);
				}
			}
			else {
				$response = array ( // Database error
					'status_code' => 4,
					'status_msg' => array('An error has been occurred')
				);
			}
			
		}
		else {
			$response = array ( // User provided invalid data
				'status_code' => 3,
				'status_msg' => $status_msg
			);
		}
			
	}
	else {
		$response = array ( // One or more fileds are empty (or author-surname is not empty only possible if bot)
			'status_code' => 2,
			'status_msg' => array('You must fill all fields')
		);
	}
}
else {
	$response = array ( // One or more fileds are not set or author-surname is set (possible only when script is direct accessed)
		'status_code' => 1,
		'status_msg' => array('An error has been occurred')
	);
}

header('Content-type: application/json');
echo json_encode($response);
	exit;
		
	}
	

    public function new_comment() {

        $allPosts = $this->input->post(NULL, TRUE);
        $userId = $this->curUser['user_id'];

//        taging
        $tagUsers = $allPosts['tagUser'];
//        remove duplicates
        $tagUsers = explode(',', $tagUsers);
        $tagUsers = array_unique($tagUsers);

        $data = array(
            'post_id' => $allPosts['postId'],
            'user_id' => $userId,
            'comment_body' => $allPosts['comment'],
            'parent_id' => $allPosts['parent']
        );
        $result = $this->model->insert($data);
        $commentId = $this->db->insert_id();
        if ($result > 0) {

//   TAGING
            foreach ($tagUsers as $i => $taguserId) {
                $dataTag[] = array(
                    'comment_id' => $commentId,
                    'user_id' => $taguserId,
                );
            }
//           print_r($dataTag);exit;
            $tagModel = load_basic_model('tag_comments');
            $tagModel->insert_batch($dataTag);


            $comment = "<li>".$this->curUser['first_name'].": ".$allPosts['comment']."</li>";
//            $postBack = array('msg' => '1', 'comment' => $comment);
            //
            $profileModel= model_load_model('Profile_model');
            $userInfo = $profileModel->getUserInfo($userId);
            $template = '';
            $template .= '<div class="row comment-row" id="'.$commentId.'">';
            $template .= '<a class="delete comment-del hidden" href="javascript:void(0)">x</a>';
            $template .= '<div class="profile-img">';
            $template .= '<img src="'.base_url().'assets/images/profile_images/'.$userInfo['profile_image'].'" alt="" title="">';
            $template .= '</div>';
            $template .= '<div class="block-content">';
            $template .= '<a href="javascript:void(0)">'.$userInfo['first_name'].':</a>';
            $template .= '<span>'.$allPosts['comment'].'</span>';
            $template .= '<ul>';
            $template .= '<li><img src="'.base_url().'assets/images/like-img2.png" alt="" title=""><a href="javascript:void(0)">Like</a></li>';
            $template .= '<li>';
            $template .= '<a href="javascript:void(0)" class="comment-reply">Reply</a>';

            $template .= '</li>';
            $template .= '<div style="clear:both"></div>';
            $template .= '</ul>';
            $template .= '</div>';
            $template .= '<div style="clear:both"></div>';
            $template .= '</div>';
            
            $postBack = array('msg' => '1', 'comment' => $template);
        } else {
            $postBack = array('msg' => '0');
        }
        echo json_encode($postBack);
        exit;
//        print_r($allPosts);exit;
//        $model = model_load_model('Profile_model');
//        $data['profileData'] = $model->getUserInfo($this->curUser['user_id']);
//        render_view('profile', $data);
    }

}
