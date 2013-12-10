<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class CommentController extends AbstractController
{
    public function add()
    {
        if (Auth::getInstance()->isLoggedIn()) {
            if (trim($this->request->post['comment']) === '') {
                echo 'Error: comment is empty';
            } else {
                $this->database->insert(
                    'comments',
                    array('user_id', 'term_id', 'content'),
                    array(
                        Auth::getInstance()->user('id'),
                        $this->request->post['id'],
                        htmlentities($this->request->post['comment'])
                    )
                );
                echo 'OK';
            }
        } else {
            echo 'Error: not logged in';
        }
        $this->renderView = false;
    }

    public function delete($commentId)
    {
        if (Auth::getInstance()->hasFlag(Auth::FLAG_ADMIN)) {
            $this->database->rawQuery("DELETE FROM comments WHERE id=" . ($commentId + 0));
            echo "OK";
        } else {
            echo 'Error: you dont have rights to perform specified action';
        }
        $this->renderView = false;
    }
}
