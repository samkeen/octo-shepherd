<?php
/**
 */
namespace OctoShepherd;

class GeneralContextsTest extends BaseTestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        new ActivityContext();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

}
