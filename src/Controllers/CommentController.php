<?php
use Utils\Auth;

class CommentController{
	public function add(){
		global $database;
		if (Auth::isLoggedIn()) {
			if (trim($_REQUEST['comment']) === '') {
				echo 'Error: comment is empty';
			} else {
				$database->insert('comments', array('user_id', 'term_id', 'content'), array(Auth::user('id'), $_REQUEST['id'], htmlentities($_REQUEST['comment'])));
				echo 'OK';
			}
		} else {
			echo 'Error: not logged in';
		}
		setViewVar('dontRenderView', true);
	}

	public function delete($id) {
		global $database;
		if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
			$database->rawQuery("DELETE FROM comments WHERE id=" . ($id + 0));
			echo "OK";
		} else {
			echo 'Error: you dont have rights to perform specified action';
		}
		setViewVar('dontRenderView', true);
	}
}
?>
