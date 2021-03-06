<?php

namespace Terminas\Controllers;

use Utils\AbstractController;
use Utils\Auth;

/**
 * Every method (except constructor of course) represents single action in admin panel.
 * And we have much clickable things in there. Probably would need to split up links,
 * but right know there's no support for prefixed routes like /admin/comments/view/22.
 *
 * @SuppressWarnings(PHPMD.TooManyMethods)
 */
class AdminController extends AbstractController
{
    public function __construct()
    {
        call_user_func_array(array(self, '__construct'), func_get_args());
        if (!Auth::getInstance()->hasFlag(Auth::FLAG_ADMIN)) {
            redirect("login/");
        }
    }

    public function index()
    {
        $comments    = $this->database->rawQuery(
            "SELECT comments.id, users.name, terms.term, comments.content " .
            "FROM comments, users, terms " .
            "WHERE (comments.user_id = users.id) AND (comments.term_id = terms.id) " .
            "ORDER BY comments.id DESC LIMIT 5"
        );
        $submissions = $this->database->rawQuery(
            "SELECT submissions.id, submissions.term, submissions.meaning, submissions.comment " .
            "FROM submissions ORDER BY id DESC LIMIT 5"
        );

        $terms = $this->database->select('terms', array('term', 'hits'), array(), 'hits DESC', 7);
        $lim   = $this->database->select('terms', array('MAX(hits) as max', 'MIN(hits) as min', 'SUM(hits) as sum'));
        $lim   = $lim[0];

        $termCloud = array();
        $sum       = 0;
        foreach ($terms as $term) {
            $termCloud['\"' . $term['term'] . '\"'] = round($term['hits'] / $lim['sum'] * 100, 0);
            $sum += $term['hits'];
        }
        $termCloud['kiti'] = round($sum / $lim['sum'] * 100, 0);

        return array(
            'comments'       => $comments,
            'submissions'    => $submissions,
            'termCloudHits'  => implode(',', array_values($termCloud)),
            'termCloudTerms' => '"%%.% ' . implode('","%%.% ', array_keys($termCloud)) . '"'
        );
    }

    public function terms()
    {
        $data = $this->database->select('terms', array('id', 'term', 'meaning'), array(), 'term ASC');

        return array(
            'terms' => $data
        );
    }

    public function editterm($termId)
    {
        $data = $this->database->select("terms", array("id", "term", "meaning"), array('id' => (int)$termId));
        if (($data !== null) && (isset($data[0]))) {
            $data = $data[0];
        } else {
            $data = array("id" => null, "term" => "", "meaning" => "");
        }

        return array(
            'term' => $data
        );
    }

    public function saveterm()
    {
        $post = $this->database->escape($this->request->post);
        if (empty($this->request->post['id'])) {
            $this->database->insert('terms', array('term', 'meaning'), array($post['term'], $post['meaning']));
        } else {
            $this->database->rawQuery(
                "UPDATE terms SET term='{$post['term']}', meaning='{$post['meaning']}' WHERE id={$post['id']}"
            );
        }
        redirect("admin/terms/");

        $this->renderView = false;
    }

    public function users()
    {
        $data = $this->database->select('users', array('id', 'name', 'email', '(flags && 1 != 0) as isAdmin'));

        return array(
            'users' => $data
        );
    }

    public function comments()
    {
        $data = $this->database->rawQuery(
            "SELECT comments.id, comments.user_id, users.name, terms.term, comments.content " .
            "FROM comments, users, terms WHERE (comments.user_id = users.id) AND (comments.term_id = terms.id) " .
            "ORDER BY comments.id DESC"
        );

        return array(
            'comments' => $data
        );
    }

    public function submissions()
    {
        $data = $this->database->select("submissions", array("id", "ip", "term", "meaning", "comment"));

        return array(
            'submissions' => $data
        );
    }

    public function editsubmission($submissionId)
    {
        $data = $this->database->select(
            "submissions",
            array("id", "ip", "term", "meaning", "comment"),
            array('id' => (int)$submissionId)
        );

        return array(
            'submission' => $data
        );
    }

    public function edituser($query)
    {
        $data = $this->database->select('users', array('id', 'name', 'email', 'flags'), array('id' => $query));
        if (isset($data[0])) {
            $data = $data[0];
        } else {
            $data = array('id' => null, 'name' => null, 'email' => null, 'flags' => 0);
        }

        return array(
            'user'    => $data,
            'isAdmin' => $data['flags'] && 1 !== 0 ? 'checked' : '',
        );
    }

    public function saveuser()
    {
        $flags = 0;
        if (isset($this->request->post['flags'])) {
            foreach ($this->request->post['flags'] as $key => $value) {
                if ($value === 'on') {
                    $flags += (int)pow(2, $key + 0);
                }
            }
        }
        $post = $this->database->escape($this->request->post);
        if (empty($this->request->post['id'])) {
            $this->database->insert(
                'users',
                array('name', 'email', 'password', 'flags'),
                array($post['name'], $post['email'], "SHA1({$post['password']})", $flags)
            );
        } else {
            if (empty($this->request->post['password'])) {
                $this->database->rawQuery(
                    "UPDATE users SET name='{$post['name']}', email='{$post['email']}', flags={$flags} " .
                    "WHERE id={$post['id']}"
                );
            } else {
                $this->database->rawQuery(
                    "UPDATE users " .
                    "SET name='{$post['name']}', email='{$post['email']}', password=SHA1('{$post['password']}'), " .
                    "flags={$flags} " .
                    "WHERE id={$post['id']}"
                );
            }
        }
        header("Location: " . WEB_ROOT . "admin/users/");

        $this->renderView = false;
    }
}
