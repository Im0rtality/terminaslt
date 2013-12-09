<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

class AdminController extends AbstractController
{
    public function __construct()
    {
        parent::__construct(func_get_args());
        if (!Auth::hasFlag(Auth::FLAG_ADMIN)) {
            redirect("login/");
        }
    }

    public function index()
    {
        $comments    = $this->database->rawQuery("SELECT comments.id, users.name, terms.term, comments.content FROM comments, users, terms WHERE (comments.user_id = users.id) AND (comments.term_id = terms.id) ORDER BY comments.id DESC LIMIT 5");
        $submissions = $this->database->rawQuery("SELECT submissions.id, submissions.term, submissions.meaning, submissions.comment FROM submissions ORDER BY id DESC LIMIT 5");

        $terms = $this->database->select('terms', array('term', 'hits'), array(), 'hits DESC', 7);
        $lim   = $this->database->select('terms', array('MAX(hits) as max', 'MIN(hits) as min', 'SUM(hits) as sum'));
        $lim   = $lim[0];

        setViewVar('comments', $comments);
        setViewVar('submissions', $submissions);
        $termCloud = array();
        $sum       = 0;
        foreach ($terms as $term) {
            $termCloud['\"' . $term['term'] . '\"'] = round($term['hits'] / $lim['sum'] * 100, 0);
            $sum += $term['hits'];
        }
        $termCloud['kiti'] = round($sum / $lim['sum'] * 100, 0);
        setViewVar('termCloudHits', implode(',', array_values($termCloud)));
        setViewVar('termCloudTerms', '"%%.% ' . implode('","%%.% ', array_keys($termCloud)) . '"');
    }

    public function terms()
    {
        $data = $this->database->select('terms', array('id', 'term', 'meaning'), array(), 'term ASC');

        setViewVar('terms', $data);
    }

    public function editterm($id)
    {
        $data = $this->database->select("terms", array("id", "term", "meaning"), array('id' => (int)$id));
        if (($data !== null) && (isset($data[0]))) {
            $data = $data[0];
        } else {
            $data = array("id" => null, "term" => "", "meaning" => "");
        }
        setViewVar('term', $data);
    }

    public function saveterm()
    {
        debug($_POST);
        $post = $this->database->escape($_POST);
        if (empty($_POST['id'])) {
            $this->database->insert('terms', array('term', 'meaning'), array($post['term'], $post['meaning']));
        } else {
            $this->database->rawQuery("UPDATE terms SET term='{$post['term']}', meaning='{$post['meaning']}' WHERE id={$post['id']}");
        }
        redirect("admin/terms/");

        $this->renderView = false;
    }

    public function users()
    {
        $data = $this->database->select('users', array('id', 'name', 'email', '(flags && 1 != 0) as isAdmin'));

        setViewVar('users', $data);
    }

    public function comments()
    {
        $data = $this->database->rawQuery("SELECT comments.id, comments.user_id, users.name, terms.term, comments.content FROM comments, users, terms WHERE (comments.user_id = users.id) AND (comments.term_id = terms.id) ORDER BY comments.id DESC");

        setViewVar('comments', $data);
    }

    public function submissions()
    {
        $data = $this->database->select("submissions", array("id", "ip", "term", "meaning", "comment"));

        setViewVar('submissions', $data);
    }

    public function editsubmission($id)
    {
        $data = $this->database->select("submissions", array("id", "ip", "term", "meaning", "comment"), array('id' => (int)$id));

        setViewVar('submission', $data[0]);
    }

    public function edituser($query)
    {
        $data = $this->database->select('users', array('id', 'name', 'email', 'flags'), array('id' => $query));
        if (isset($data[0])) {
            $data = $data[0];
        } else {
            $data = array('id' => null, 'name' => null, 'email' => null, 'flags' => 0);
        }

        setViewVar('user', $data);
        setViewVar('isAdmin', $data['flags'] && 1 !== 0 ? 'checked' : '');
    }

    public function saveuser()
    {
        debug($_POST);
        $flags = 0;
        if (isset($_POST['flags'])) {
            foreach ($_POST['flags'] as $key => $value) {
                if ($value === 'on') {
                    $flags += (int)pow(2, $key + 0);
                }
            }
        }
        $post = $this->database->escape($_POST);
        if (empty($_POST['id'])) {
            $this->database->insert('users', array('name', 'email', 'password', 'flags'), array($post['name'], $post['email'], "SHA1({$post['password']})", $flags));
        } else {
            if (empty($_POST['password'])) {
                $this->database->rawQuery("UPDATE users SET name='{$post['name']}', email='{$post['email']}', flags={$flags} WHERE id={$post['id']}");
            } else {
                $this->database->rawQuery("UPDATE users SET name='{$post['name']}', email='{$post['email']}', password=SHA1('{$post['password']}'), flags={$flags} WHERE id={$post['id']}");
            }
        }
        header("Location: " . WEB_ROOT . "admin/users/");

        $this->renderView = false;
    }
}
