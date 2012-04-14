<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace Phpgithubapi\Auth;

class SimpleAuthTest extends \PHPUnit_Framework_TestCase
{
    function testInstantiateNoExplotions()
    {
        new SimpleAuth();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }
}
