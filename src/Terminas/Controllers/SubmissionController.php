<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class SubmissionController extends AbstractController
{
    public function delete($id)
    {
        if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
            $this->database->rawQuery("DELETE FROM submissions WHERE id=" . ($id + 0));
            echo "OK";
        } else {
            echo 'Error: you dont have rights to perform specified action';
        }
        $this->renderView = false;
    }
}
