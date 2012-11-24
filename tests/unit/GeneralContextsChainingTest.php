<?php
/**
 */
namespace OctoShepherd;

class GeneralContextsChainingTest extends \PHPUnit_Framework_TestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        $api = new Api(null, null);
        $starring = $api->activity()->starring();
        $this->assertInstanceOf(__NAMESPACE__ . '\\Activity\StarringSubContext', $starring);
    }

    function testFoo()
    {
        $conf = require __DIR__ . '/../../src/conf/conf.php';
        $api = new Api($conf, new \Presta\Request());
        $result = $api->get_my_repos();
        $starring = $api->activity()->starring();
        $this->assertInstanceOf(__NAMESPACE__ . '\\Activity\StarringSubContext', $starring);
    }



}