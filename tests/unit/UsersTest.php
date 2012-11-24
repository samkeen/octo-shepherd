<?php
/**
 * These are tests for the user[s] endpoint
 * @see http://developer.github.com/v3/users/
 */
namespace OctoShepherd;

class UsersTest extends \PHPUnit_Framework_TestCase
{
   
    /*
     * The Me tests are for the shortcut endpoint /user (rather than /users) 
     * that returns the currently authenticated User
     */
    
    
    function testMeReturnsOctoObject()
    {
        $herder = new Api(
            array(),
            $this->get_response_mocking_curl_wrapper_for('/user')
        );
        $me = $herder->me();
        $this->assertInstanceOf('\OctoShepherd\OctoObject', $me);
    }
    
    function testMeHasExpectedMinimumSetOfAttributes()
    {
        $herder = new Api(
            array(),
            $this->get_response_mocking_curl_wrapper_for('/user')
        );
        $me = $herder->me();
        $this->assertNotEmpty(
            $me->url,
            "Github User should always have a non empty `url` attribute"
        );
        $this->assertEquals(
            $me->type,
            "User",
            "Github User should always have a `type` attribute and the value should be: 'User'"
        );
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testUsersEmptyParamThrowsException()
    {
        $herder = new Api();
        $herder->users('');
    }
    
    function testUsersReturnsOctoObject()
    {
        $herder = new Api(
            array(),
            $this->get_response_mocking_curl_wrapper_for('/users/octocat')
        );
        $octocat = $herder->users('octocat');
        $this->assertInstanceOf('\OctoShepherd\OctoObject', $octocat);
    }
    
    function testUsersReturnsExpectedUserAttribute()
    {
        $herder = new Api(
            array(),
            $this->get_response_mocking_curl_wrapper_for('/users/octocat')
        );
        $octocat = $herder->users('octocat');
        $this->assertTrue($octocat->has('login'));
        $this->assertEquals(
            'octocat',
            $octocat->login
        );
    }
    
    function testUsersUnknownUserReturnsNull()
    {
        $username = 'not-a-user'.uniqid();
        $herder = new Api(
            array(),
            $this->get_response_mocking_curl_wrapper_for("/users/{$username}")
        );
        $octocat = $herder->users($username);
        $this->assertNull($octocat);
    }
    
    function testUsersUnknownUserLastErrorIs404()
    {
        $username = 'not-a-user'.uniqid();
        $herder = new Api(
            array(),
            $this->get_response_mocking_curl_wrapper_for("/users/{$username}")
        );
        $octocat = $herder->users($username);
        $error = $herder->last_error();
        $this->assertEquals(
            '404',
            $error['status_code']
        );
    }
    
    
    /**
     * This mocks the Curl wrapper and the execute call is set to return the
     * appropriate mock stored in folder response_stubs
     *
     * @param string $endpoint
     * @return \Presta\Request
     * (actually returns: \PHPUnit_Framework_MockObject_MockObject)
     */
    protected function get_response_mocking_curl_wrapper_for($endpoint)
    {
        $endpoint = trim($endpoint, ' /');
        $endpoint = str_replace('/', '.', $endpoint);
        $mock_curler = $this->getMockBuilder('\Presta\Request')
            ->setMethods(array('make_http_request'))
            ->getMock();
        $mock_curler
            ->expects($this->once())
            ->method('make_http_request')
            ->will($this->returnValue(MockResponseFactory::response($endpoint)));
        return $mock_curler;
    }

}
