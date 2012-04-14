<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace OctoShepherd;

class UserTest extends \PHPUnit_Framework_TestCase
{
    
    function testMe()
    {
        $mock_curler = $this->getMockBuilder('\Presta\Request')
            ->setMethods(array('make_http_request'))
            ->getMock();
        $mock_curler
            ->expects($this->once())
            ->method('make_http_request')
            ->will($this->returnValue(MockResponseFactory::response('user')));
        
        $herder = new Shepherd(array(), $mock_curler);
        $me = $herder->me();
        $this->assertNotEmpty($me);
    }

}
