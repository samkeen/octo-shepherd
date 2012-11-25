<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace OctoShepherd;

class RequesterTest extends BaseTestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateEmptyParamsThrowsException()
    {
        new Requester(array(), new \Presta\Request());
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateExceptionIfOnlyAuthNameSupplied()
    {
        new Requester(array(
            'base_url'  => 'https://api.github.com',
            'auth_name' => 'foo'
        ), new \Presta\Request());
    }

    function testInstantiateNoExceptionIfAccessTokenSupplied()
    {
        new Requester(array(
            'base_url'     => 'https://api.github.com',
            'access_token' => 'foo'
        ), new \Presta\Request());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

    function testInstantiateNoExceptionIfAuthNameAndAuthPasswordSupplied()
    {
        new Requester(array(
            'base_url'      => 'https://api.github.com',
            'auth_name'     => 'bob',
            'auth_password' => 'secret'
        ), new \Presta\Request());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateExceptionIfAuthNameAndAuthPasswordSuppliedButNoBaseUrl()
    {
        new Requester(array(
            'auth_name'     => 'bob',
            'auth_password' => 'secret'
        ), new \Presta\Request());
        $this->assertTrue(true, "Just testing that we are able to Instantiate");
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    function testGetExceptionForNoReplacementValues()
    {
        $req = new Requester(array(
            'base_url'     => 'https://api.github.com',
            'access_token' => 'foo'
        ), new \Presta\Request());
        $req->get('/user/starred/:owner/:repo');
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testGetExceptionForTooFewReplacementValues()
    {
        $req = new Requester(array(
            'base_url'     => 'https://api.github.com',
            'access_token' => 'foo'
        ), new \Presta\Request());
        $req->get('/user/starred/:owner/:repo', $owner='bob');
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testGetExceptionForTooManyReplacementValues()
    {
        $req = new Requester(array(
            'base_url'     => 'https://api.github.com',
            'access_token' => 'foo'
        ), new \Presta\Request());
        $req->get('/user/starred/:owner/:repo', $owner='bob', $repo='foo', $bar='baz');
    }

    function testGetNoExceptionForProperAmountOfReplacementValues()
    {
        new Requester(array(
            'base_url'     => 'https://api.github.com',
            'auth_name'     => 'bob',
            'auth_password' => 'secret!'
        ), new \Presta\Request());
    }

    function testGetProperResponse()
    {
        $req = new Requester(array(
            'base_url'     => 'https://api.github.com',
            'auth_name'     => 'bob',
            'auth_password' => 'secret!'
        ), $this->get_response_mocking_curl_wrapper_for('/users/octocat/starred'));
        $response = $req->get('/users/:user/starred', $user='octocat');
    }

}
