<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class CommentController extends AbstractController
{
    public function add()
    {
        if (Auth::isLoggedIn()) {
            if (trim($_REQUEST['comment']) === '') {
                echo 'Error: comment is empty';
            } else {
                $this->database->insert('comments', array('user_id', 'term_id', 'content'), array(Auth::user('id'),
                    $_REQUEST['id'], htmlentities($_REQUEST['comment'])));
                echo 'OK';
            }
        } else {
            echo 'Error: not logged in';
        }
        $this->renderView = false;
    }

    public function delete($id)
    {
        if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
            $this->database->rawQuery("DELETE FROM comments WHERE id=" . ($id + 0));
            echo "OK";
        } else {
            echo 'Error: you dont have rights to perform specified action';
        }
        $this->renderView = false;
    }
}
