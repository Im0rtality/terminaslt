<?php

namespace Terminas\Controller;

use Utils\Auth;

class SubmissionController
{
    public function delete($id)
    {
        global $database;
        if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
            $database->rawQuery("DELETE FROM submissions WHERE id=" . ($id + 0));
            echo "OK";
        } else {
            echo 'Error: you dont have rights to perform specified action';
        }
        setViewVar('dontRenderView', true);
    }
}

