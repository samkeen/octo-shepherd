<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace OctoShepherd;

class RequesterTest extends \PHPUnit_Framework_TestCase
{   
    function testInstantiateEmptyParamsNoExplosions()
    {
        new Requester();
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testGetExceptionForNoReplacementValues()
    {
        $req = new Requester();
        $req->get('/user/starred/:owner/:repo');
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testGetExceptionForTooFewReplacementValues()
    {
        $req = new Requester();
        $req->get('/user/starred/:owner/:repo', $owner='bob');
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testGetExceptionForTooManyReplacementValues()
    {
        $req = new Requester();
        $req->get('/user/starred/:owner/:repo', $owner='bob', $repo='foo', $bar='baz');
    }

    function testGetNoExceptionForProperAmountOfReplacementValues()
    {
        $req = new Requester();
        $req->get('/user/starred/:owner/:repo', $owner='bob', $repo='foo');
    }

}
