<?php


namespace Tests\Functional;


use Utils\Request;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function getTestFieldData()
    {
        $out = array();
        // case #0
        $out[] = array(
            'get',
            array(1, 42, 666),
            array(666, 42, 1),
            array(1, 42, 666)
        );
        // case #1
        $out[] = array(
            'post',
            array(1, 42, 666),
            array(666, 42, 1),
            array(666, 42, 1)
        );
        // case #2
        $_POST = 'my dummy post text';
        $out[] = array(
            'post',
            null,
            null,
            'my dummy post text'
        );
        // case #3
        $_GET  = 'my dummy get text';
        $out[] = array(
            'get',
            null,
            null,
            'my dummy get text'
        );
        return $out;
    }

    /**
     * @dataProvider getTestFieldData
     *
     * @param $field
     * @param $globalGet
     * @param $globalPost
     * @param $expected
     */
    public function testFieldData($field, $globalGet, $globalPost, $expected)
    {
        $request = new Request($globalPost, $globalGet);
        $this->assertEquals($expected, $request->$field->dump());
    }
}
