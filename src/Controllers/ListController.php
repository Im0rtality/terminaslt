<?php
class ListController
{
    public function index($query = '', $terms = null)
    {
        global $database;
        $data = $database->select('terms', array('term'), "term LIKE '%$query%'");

        $key = 'term';
        $val = array();
        array_walk_recursive($data, function ($v, $k) use ($key, &$val) {
            if ($k == $key) array_push($val, $v);
        });
        $data = count($val) > 1 ? $val : array_pop($val);

        setViewVar('dontRenderDefault', true);
        setViewVar('data', $data);
    }
}

