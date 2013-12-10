<?php


namespace Tests\Functional;


use Utils\HtmlHelper;

class HtmlHelperTest extends \PHPUnit_Framework_TestCase
{

    public function getTestUrlData()
    {
        $out = array();
        // case #0
        $out[] = array(true, 'ROOT', 'controller', 'action', 'param', 'ROOTcontroller/action/param/');
        // case #1
        $out[] = array(true, 'ROOT', 'controller', 'action', '', 'ROOTcontroller/action/');
        // case #2
        $out[] = array(true, 'ROOT', 'controller', '', '', 'ROOTcontroller/');
        // case #3
        $out[] = array(true, 'ROOT', '', '', '', 'ROOT/');
        // case #4
        $out[] = array(
            false,
            'ROOT',
            'controller',
            'action',
            'param',
            'ROOTindex.php?controller=controller&action=action&params=param'
        );
        // case #5
        $out[] = array(
            false,
            'ROOT',
            'controller',
            'action',
            '',
            'ROOTindex.php?controller=controller&action=action&params='
        );
        // case #6
        $out[] = array(
            false,
            'ROOT',
            'controller',
            '',
            '',
            'ROOTindex.php?controller=controller&action=&params='
        );

        // case #7
        $out[] = array(
            false,
            'ROOT',
            '',
            '',
            '',
            'ROOTindex.php?controller=&action=&params='
        );
        return $out;
    }

    /**
     * @dataProvider getTestUrlData
     *
     * @param $modRewrite
     * @param $root
     * @param $controller
     * @param $action
     * @param $params
     * @param $expected
     */
    public function testUrl($modRewrite, $root, $controller, $action, $params, $expected)
    {
        $helper = new HtmlHelper($modRewrite);
        $helper->setRoot($root);
        $this->assertEquals($expected, $helper->url($controller, $action, $params));
    }
}
