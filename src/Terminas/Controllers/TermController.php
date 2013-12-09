<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class TermController extends AbstractController
{
    public function submit()
    {
        foreach ($this->request->post as &$val) {
            if (is_string($val)) {
                $val = htmlentities($val);
            }
        }
        if (isset($this->request->post['term']) && isset($this->request->post['meaning'])) {
            $this->database->insert(
                'submissions',
                array('ip', 'term', 'meaning', 'comment'),
                array_merge(array($_SERVER['REMOTE_ADDR']), $this->request->post->dump())
            );
        }
        $this->renderView = false;
        redirect("");
    }

    public function view($query = '')
    {
        $term = $this->database->select('terms', array('id', 'term', 'meaning'), array('term' => $query));
        if (count($term) > 0) {
            $term[0]['meaning'] = str_replace("\n", "</p><p>", $term[0]['meaning']);
            $data               = $this->database->rawQuery(
                "SELECT comments.id, users.name, comments.content " .
                "FROM comments, users " .
                "WHERE (comments.user_id = users.id) AND (comments.term_id = {$term[0]['id']}) " .
                "ORDER BY comments.id ASC"
            );
            $this->database->update('terms', array('hits'), array('hits + 1'), array('id' => $term[0]['id']));
        } else {
            $data = array();
        }

        return array(
            'isTerm'   => count($term) > 0,
            'data'     => $term[0],
            'comments' => $data,
            'query'    => $query
        );
    }

    public function delete($termId)
    {
        if (Auth::hasFlag(Auth::FLAG_ADMIN)) {
            $this->database->rawQuery("DELETE FROM terms WHERE id=" . ($termId + 0));
            echo "OK";
        } else {
            echo 'Error: you dont have rights to perform specified action';
        }
        $this->renderView = false;
    }
}
