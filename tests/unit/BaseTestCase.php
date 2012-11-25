<?php
namespace OctoShepherd;
/**
 * Created by JetBrains PhpStorm.
 * User: sam
 * Date: 11/25/12
 * Time: 11:09 AM
 * To change this template use File | Settings | File Templates.
 */
class BaseTestCase extends \PHPUnit_Framework_TestCase
{
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
