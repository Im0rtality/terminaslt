<?php

namespace Tests\Functional;

use Utils\ParameterBag;

class ParameterBagTest extends \PHPUnit_Framework_TestCase
{

    public function getTestDumpData()
    {
        $out = array();
        // case #0 - dump should return whatever we have in the bag
        $out[] = array(
            1,
            1
        );
        // case #1
        $out[] = array(
            array(),
            array()
        );

        return $out;
    }

    /**
     * @dataProvider getTestDumpData
     *
     * @param $data
     * @param $expected
     */
    public function testDump($data, $expected)
    {
        $bag = new ParameterBag($data);
        $this->assertEquals($expected, $bag->dump());
    }

    public function getTestGetData()
    {
        $out = array();
        // case #0
        $out[] = array(
            array('a' => 'aa', 'b' => 'bb', 'c' => 'cc'),
            array('c', 'a'),
            array('cc', 'aa')
        );

        return $out;
    }

    /**
     * @dataProvider getTestGetData
     *
     * @param $data
     * @param $keys
     * @param $expected
     */
    public function testGet($data, $keys, $expected)
    {
        $bag = new ParameterBag($data);
        $out = array();
        foreach ($keys as $key) {
            $out[] = $bag[$key];
        }
        $this->assertEquals($expected, $out);
    }

    public function getTestSetData()
    {
        $out = array();
        // case #0
        $out[] = array(
            array('a', 'b'),
            array('aa', 'bb'),
            array('a' => 'aa', 'b' => 'bb'),
        );

        return $out;
    }

    /**
     * @dataProvider getTestSetData
     *
     * @param $keys
     * @param $values
     * @param $expected
     */
    public function testSet($keys, $values, $expected)
    {
        $bag = new ParameterBag(array());
        foreach ($keys as $k => $key) {
            $bag[$key] = $values[$k];
        }
        $this->assertEquals($expected, $bag->dump());
    }

    public function getTestIssetData()
    {
        $out = array();
        // case #0
        $out[] = array(
            array('a' => 'aa', 'b' => 'bb'),
            array('a', 'b', 'c'),
            array(true, true, false),
        );

        return $out;
    }

    /**
     * @dataProvider getTestIssetData
     *
     * @param $data
     * @param $keys
     * @param $expected
     */
    public function testIsset($data, $keys, $expected)
    {
        $bag = new ParameterBag($data);
        $out = array();
        foreach ($keys as $key) {
            $out[] = isset($bag[$key]);
        }
        $this->assertEquals($expected, $out);
    }
}
