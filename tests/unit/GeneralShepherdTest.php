<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace OctoShepherd;

class GeneralShepherdTest extends \PHPUnit_Framework_TestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        new Shepherd();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
    
    function testInstantiateEmptyArrayParamNoExplosions()
    {
        new Shepherd(array());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
    
    function testInstantiateKnownKeysNoExplosions()
    {
        new Shepherd(array('auth-name' => 'bob', 'auth-password' => 'secret'));
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
    
    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateUnKnownKeysExplodes()
    {
        new Shepherd(array('unknown-key' => 'bob', 'auth-password' => 'secret'));
    }
    
    function testInstantiateWithPrestaNoExplosions()
    {
        new Shepherd(array(), new \Presta\Request());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
}
