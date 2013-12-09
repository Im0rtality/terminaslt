<?php

namespace Terminas\Controllers;

use Utils\AbstractController;

class ListController extends AbstractController
{
    public function index($query = '', $terms = null)
    {
        $data = $this->database->select('terms', array('term'), "term LIKE '%$query%'");

        $key = 'term';
        $val = array();
        array_walk_recursive(
            $data,
            function ($val2, $key2) use ($key, &$val) {
                if ($key2 == $key) {
                    array_push($val, $val2);
                }
            }
        );
        $data = count($val) > 1 ? $val : array_pop($val);

        $this->renderDefault = false;
        setViewVar('data', $data);
    }
}
