<?php
class TermController {
	public function submit($query){
		global $DB;
		// debug($_POST);
		foreach ($_POST as &$val){
			if (is_string($val)) {
				$val = htmlentities($val);
			}
		}
		if (isset($_POST['term']) && isset($_POST['meaning'])) {
			$DB->insert('submissions', array('ip', 'term', 'meaning', 'comment'), array_merge(array($_SERVER['REMOTE_ADDR']), $_POST));
		}
		setViewVar('dontRenderView', true);
		redirect();
	}

	public function view($query = ''){
		global $DB;
		$term = $DB->select('terms', array('id', 'term', 'meaning'), array('term' => $query));
		setViewVar('isTerm', count($term) > 0);
		if (count($term) > 0) {
			$term[0]['meaning'] = str_replace("\n", "</p><p>", $term[0]['meaning']);
			setViewVar('data', $term[0]);
			$data = $DB->rawQuery("SELECT comments.id, users.name, comments.content FROM comments, users WHERE (comments.user_id = users.id) AND (comments.term_id = {$term[0]['id']}) ORDER BY comments.id ASC");
			setViewVar('comments', $data);
			$DB->update('terms', array('hits'), array('hits + 1'), array('id' => $term[0]['id']));
		}
		setViewVar('query', $query);
	}

	public function delete($id) {
		global $DB;
		if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
			$DB->rawQuery("DELETE FROM terms WHERE id=" . ($id + 0));
			echo "OK";
		} else {
			echo 'Error: you dont have rights to perform specified action';
		}
		setViewVar('dontRenderView', true);
	}
}
?>