<?php
class AdminController {
	public function __construct(){
		if (!Auth::hasFlag(Auth::FLAG_ADMIN)) {
			redirect("login/");
		}
	}

	public function index(){
		global $database;
		$comments = $database->rawQuery("SELECT comments.id, users.name, terms.term, comments.content FROM comments, users, terms WHERE (comments.user_id = users.id) AND (comments.term_id = terms.id) ORDER BY comments.id DESC LIMIT 5");
		$submissions = $database->rawQuery("SELECT submissions.id, submissions.term, submissions.meaning, submissions.comment FROM submissions ORDER BY id DESC LIMIT 5");

		$terms = $database->select('terms', array('term', 'hits'), array(), 'hits DESC', 7);
		$lim = $database->select('terms', array('MAX(hits) as max', 'MIN(hits) as min', 'SUM(hits) as sum'));
		$lim = $lim[0];

		setViewVar('comments', $comments);
		setViewVar('submissions', $submissions);
		$termCloud = array();
		$sum = 0;
		foreach($terms as $term) {
			$termCloud['\"'.$term['term'].'\"'] = round($term['hits'] / $lim['sum'] * 100, 0);
			$sum += $term['hits'];
		}
		$termCloud['kiti'] = round($sum / $lim['sum'] * 100, 0);
		setViewVar('termCloudHits', implode(',', array_values($termCloud)));
		setViewVar('termCloudTerms', '"%%.% ' . implode('","%%.% ', array_keys($termCloud)) . '"');
	}

	public function terms(){
		global $database;
		$data = $database->select('terms', array('id', 'term', 'meaning'), array(), 'term ASC');

		setViewVar('terms', $data);
	}

	public function editterm($id){
		global $database;
		$data = $database->select("terms", array("id", "term", "meaning"), array('id' => (int) $id));
		if (($data !== null) && (isset($data[0]))){
			$data = $data[0];
		} else {
			$data = array("id" => null, "term" => "", "meaning" => "");
		}
		setViewVar('term', $data);
	}

	public function saveterm(){
		global $database;
		debug($_POST);
		$post = $database->escape($_POST);
		if (empty($_POST['id'])) {
			$database->insert('terms', array('term', 'meaning'), array($post['term'], $post['meaning']));
		} else {
			$database->rawQuery("UPDATE terms SET term='{$post['term']}', meaning='{$post['meaning']}' WHERE id={$post['id']}");
		}
		redirect("admin/terms/");

		setViewVar('dontRenderView', true);
	}

	public function users(){
		global $database;
		$data = $database->select('users', array('id', 'name', 'email', '(flags && 1 != 0) as isAdmin'));

		setViewVar('users', $data);
	}

	public function comments(){
		global $database;
		$data = $database->rawQuery("SELECT comments.id, comments.user_id, users.name, terms.term, comments.content FROM comments, users, terms WHERE (comments.user_id = users.id) AND (comments.term_id = terms.id) ORDER BY comments.id DESC");

		setViewVar('comments', $data);
	}

	public function submissions(){
		global $database;
		$data = $database->select("submissions", array("id", "ip", "term", "meaning", "comment"));

		setViewVar('submissions', $data);
	}

	public function editsubmission($id){
		global $database;
		$data = $database->select("submissions", array("id", "ip", "term", "meaning", "comment"), array('id' => (int) $id));

		setViewVar('submission', $data[0]);
	}

	public function edituser($query){
		global $database;
		$data = $database->select('users', array('id', 'name', 'email', 'flags'), array('id' => $query));
		if (isset($data[0])) {
			$data = $data[0];
		} else {
			$data = array('id' => null, 'name' => null, 'email' => null, 'flags' => 0);
		}

		setViewVar('user', $data);
		setViewVar('isAdmin', $data['flags'] && 1 !== 0 ? 'checked' : '');
	}

	public function saveuser(){
		global $database;
		debug($_POST);
		$flags = 0;
		if (isset($_POST['flags'])) {
			foreach($_POST['flags'] as $key=>$value){
				if ($value === 'on') {
					$flags += (int) pow(2, $key + 0);
				}
			}
		}
		$post = $database->escape($_POST);
		if (empty($_POST['id'])) {
			$database->insert('users', array('name', 'email', 'password', 'flags'), array($post['name'], $post['email'], "SHA1({$post['password']})", $flags));
		} else {
			if (empty($_POST['password'])) {
				$database->rawQuery("UPDATE users SET name='{$post['name']}', email='{$post['email']}', flags={$flags} WHERE id={$post['id']}");
			} else {
				$database->rawQuery("UPDATE users SET name='{$post['name']}', email='{$post['email']}', password=SHA1('{$post['password']}'), flags={$flags} WHERE id={$post['id']}");
			}
		}
		header("Location: ".WEB_ROOT."admin/users/");

		setViewVar('dontRenderView', true);
	}
}
?>
