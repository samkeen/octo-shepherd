<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace OctoShepherd;

class GeneralShepherdTest extends BaseTestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        new Api();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
    
    function testInstantiateEmptyArrayParamNoExplosions()
    {
        new Api(array());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
    
    function testInstantiateKnownKeysNoExplosions()
    {
        new Api(array('auth-name' => 'bob', 'auth-password' => 'secret'));
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateUnKnownKeysExplodes()
    {
        new Api(array('unknown-key' => 'bob', 'auth-password' => 'secret'));
    }
    
    function testInstantiateWithPrestaNoExplosions()
    {
        new Api(array(), new \Presta\Request());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
}
