<?php
/**********************************************\
* Copyright (c) 2014 Manolis Agkopian          *
* See the file LICENCE for copying permission. *
\**********************************************/

class CommentHandler {
	public function insert_comment($post_id, $msg, $parent, $user_id) {
		// Connect to database
		try {
			$handler = new Database();
			

			// Insert comment to database
			if ($parent !== 'NULL') {
				$handler->beginTransaction(); // If comment has a parent begin transaction
			}
			$res = $handler->prepare('INSERT INTO `comment`(`post_id`, `user_id`, `message`, `parent`) VALUES (:post_id, :user_id, :author_email, :message, :parent)');
			
			
			$res->execute( array(
				':post_id' => $post_id,
				':user_id' => $user_id,
				':message' => $msg,
				':parent' => $parent
			));
			
		
			
			if ($res->rowCount() !== 1) {
				return false;
			}
			
			// Get cid of last comment
			$cid = $handler->lastInsertId();
			
			if ($parent !== 'NULL') {
				$res = $handler->prepare('UPDATE `comment` SET `children` = 1 WHERE `cid` = :parent');
				$res->execute( array(
					':parent' => $parent
				));
				$handler->commit(); // Commit only if both queries succeed
			}
		}
		catch (PDOException $e) {
			if ($parent !== 'NULL') {
				$handler->rollback();
			}
			return false;
		}
		
		return $cid;
	}
}
