<?php
class CommentController{
	public function add(){
		global $DB;
		if (Auth::isLoggedIn()) {
			if (trim($_REQUEST['comment']) === '') {
				echo 'Error: comment is empty';
			} else {
				$DB->insert('comments', array('user_id', 'term_id', 'content'), array(Auth::user('id'), $_REQUEST['id'], htmlentities($_REQUEST['comment'])));
				echo 'OK';
			}
		} else {
			echo 'Error: not logged in';
		}
		setViewVar('dontRenderView', true);
	}

	public function delete($id) {
		global $DB;
		if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
			$DB->rawQuery("DELETE FROM comments WHERE id=" . ($id + 0));
			echo "OK";
		} else {
			echo 'Error: you dont have rights to perform specified action';
		}
		setViewVar('dontRenderView', true);
	}
}
?>