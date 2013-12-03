<?php
class SubmissionController{
	public function delete($id) {
		global $DB;
		if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
			$DB->rawQuery("DELETE FROM submissions WHERE id=" . ($id + 0));
			echo "OK";
		} else {
			echo 'Error: you dont have rights to perform specified action';
		}
		setViewVar('dontRenderView', true);
	}
}
?>