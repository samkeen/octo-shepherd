<?php
/**
 */
namespace OctoShepherd;

class GeneralSubContextsTest extends \PHPUnit_Framework_TestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        new \OctoShepherd\Activity\StarringSubContext();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

}
