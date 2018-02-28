<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

class CommentSection {
	private $post_id = null; // Comment Section ID
	private $tree = null;
	private $status = true;
	private $display = '';

	public function __construct ( $post_id ) {
		
		if ( ($this->post_id = (int) $post_id) <= 0 ) {
			$this->sid = null;
			throw new InvalidArgumentException('Section ID must be a positive integer');
		}
		
		try {
			$this->tree = new TreeNode($this->post_id, true); // We create a peudo-node that will fetch all node with null parent
		}
		catch (Exception $e) {
			$this->status = false;
		}
		
		$this->createDisplay();
	}
	
	public function doComments() {
		echo $this->display;
	}
	
	private function createDisplay () {
		
		
		$handler = new Database();
		$sth1 = $handler->prepare('
				SELECT * From post_like
				WHERE user_id = :user_id and post_id = :post_id
			');
			$curUser = currentuser_session();
			
			// Bind the ID of the comment section and execute the statement
			$sth1->execute( array(
				':user_id' => $curUser['user_id'],
				':post_id' =>$this->post_id,
			));
		$result = $sth1->fetchAll();
		
		
		$this->display .= '<div class="comment-section" id="main-com_'.$this->post_id.'">';

		if ( $this->status === false ) {
			$this->display .= 
				'An error has been occurred'; // If database error
		}
		else if ( $this->tree->hasChildren() === false ) { // If no comment exist yet
		
		
		
			$this->display .= 
				'<ul class="like-header message-body parent_'.$this->post_id.'" id="message-">';
				
				if(count($result)>0){
				$this->display .= 	'<li class="like-button" onclick="like('.$this->post_id.')" id="like_btn_'.$this->post_id.'"><img src="'.Config::IMAGE_PATH.'/assets/images/like-img.png" alt="" title=""> Unlike</li>';
				}else{
				$this->display .= 	'<li class="like-button" onclick="like('.$this->post_id.')" id="like_btn_'.$this->post_id.'"><img src="'.Config::IMAGE_PATH.'/assets/images/like-image.png" alt="" title=""> Like</li>';	
				}
					$this->display .= 	'<li class="reply-button top-reply-button">Reply</li>
					<li style="display: none;" class="msg-text">
						<input type="hidden" name="post_id" value="' . $this->post_id . '">
						<textarea placeholder="Message"></textarea>
					</li>
					<li style="display: none;" class="hide-reply-box">Click to hide</li>
				</ul>
				<ul>
					<li>
						<ul class="message-body">
						</ul>
					</li>
				<ul>';
		}
		else {
			$this->display .= 
				'<ul class="like-header message-body parent_'.$this->post_id.'" id="message-">';
				    if(count($result)>0){
				$this->display .= 	'<li class="like-button" onclick="like('.$this->post_id.')" id="like_btn_'.$this->post_id.'"><img src="'.Config::IMAGE_PATH.'/assets/images/like-img.png" alt="" title=""> Unlike</li>';
				}else{
				$this->display .= 	'<li class="like-button" onclick="like('.$this->post_id.')" id="like_btn_'.$this->post_id.'"><img src="'.Config::IMAGE_PATH.'/assets/images/like-image.png" alt="" title=""> Like</li>';	
				}
					$this->display .= '<li class="reply-button top-reply-button">Reply</li>
					<li style="display: none;" class="msg-text">
						<input type="hidden" name="post_id" value="' . $this->post_id . '">
						<textarea placeholder="Message"></textarea>
					</li>
					<li style="display: none;" class="hide-reply-box">Click to hide</li>
				</ul>';
			
			// Generate comment markup and return
			$this->display .= $this->traverseTree($this->tree->getChildren()); // We don't want to display the pseudo-node so we pass its children
			
		}
		$this->display .= '</div>';
		$this->display .= 
			'<div class="error-com message">
				<h3>Error:</h3>
				<p></p>
			</div>
			<div class="warning message">
				<h3>Warning:</h3>
				<p></p>
			</div>';
	}
	
	private function traverseTree($tree) {
		
	
		$display = '<ul>';
		
		foreach($tree as $twig) {
			
			$handler = new Database();
				
	
				
			$sth = $handler->prepare('
				SELECT `profile_image`,`user_id`
				FROM `profile`
				WHERE `user_id` = :user_id
			');
			
			
			// Bind the ID of the comment section and execute the statement
			$sth->execute( array(
				':user_id' => $twig->getAuthor()
			));
			$result = $sth->fetchAll();
			$curUser = currentuser_session();
			$display .= '<li id="parent-of-'.$twig->getCid().'">
							<ul class="message-body" id="message-'. $twig->getCid() . '">
								<li class="author"><img class="img-circle" width="31px" height="32px" 	src="'.Config::IMAGE_PATH.'/assets/images/profile_images/'.$result[0]['profile_image'].'"></li>
								<li class="comment-msg">' . htmlentities($twig->getMessage(), ENT_QUOTES, 'UTF-8') . '</li>';
								if($curUser['user_id']==$twig->getAuthor()){
								$display .= '<li class="delete-comment" onclick="delete_comment('.$twig->getCid().')"><i class="fa fa-times" aria-hidden="true"></i></li>';
								}
								$display .= '<li class="reply-button">Reply</li>
								<li class="msg-text">
									<input type="hidden" name="post_id" value="' . $this->post_id . '">
									<textarea placeholder="Message"></textarea>
								</li>
								<li class="hide-reply-box">Click to hide</li>
							</ul>';
			
			// If the node has children inject them in a <ul> tag under parent node
			if ($twig->hasChildren()) {
				$display .= $this->traverseTree($twig->getChildren());
			}

			$display .= '</li>';	
		}
		
		return $display . '</ul>';
	}
	
}
