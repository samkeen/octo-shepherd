<?php
/**
 */
namespace OctoShepherd;

class GeneralContextsTest extends \PHPUnit_Framework_TestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        new ActivityContext();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

}
