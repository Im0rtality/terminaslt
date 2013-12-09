<?php

namespace Terminas\Controllers;

use Utils\AbstractController;

define('CLOUD_SIZE', 50);
define('CLOUD_ROW', 5);

function sortArray($array, $key)
{
    usort($array, function ($a, $b) use ($key) {
        return ($a[$key] < $b[$key]);
    });
    $tmp = array();
    for ($i = 0; $i < count($array); $i++) {
        if ($i % 2 == 0) {
            array_unshift($tmp, $array[$i]);
        } else {
            array_push($tmp, $array[$i]);
        }
    }

    return $tmp;
}

function map_value($value, $min, $max, $new_min, $new_max)
{
    return (int)(($value - $min) / ($max - $min) * ($new_max - $new_min) + $new_min);
}

class HomeController extends AbstractController
{
    public function index()
    {
        $terms = $this->database->select('terms', array('term', 'hits'), array(), 'hits DESC', CLOUD_SIZE);
        $lim   = $this->database->select('terms', array('MAX(hits) as max', 'MIN(hits) as min'), array(), 'hits DESC', CLOUD_SIZE);
        $lim   = $lim[0];

        if (count($terms) < CLOUD_SIZE) {
            $terms = array_merge(
                $terms,
                array_fill(0, CLOUD_SIZE - count($terms), array('term' => '    ', 'hits' => $lim['min'] - 1))
            );
        }

        array_walk($terms, function (&$item) use ($lim) {
            $item['scale'] = map_value($item['hits'], $lim['min'], $lim['max'], 100, 250);
        });

        $terms = sortArray($terms, 'hits');

        $termCloud = array();
        $termRow   = array();
        for ($i = 0; $i < CLOUD_SIZE; $i++) {
            $termRow[] = $terms[$i];
            if ($i % CLOUD_ROW == (CLOUD_ROW - 1)) {

                $termCloud[] = sortArray($termRow, 'hits');
                $termRow     = array();
            }
        }

        setViewVar('termCloud', $termCloud);
    }
}
