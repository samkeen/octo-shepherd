<?php
/**
 * This is just a stub test so the initial run of the build script 
 * has something to execute.
 *
 * Replace this test with your own (and use your own namespace)
 */
namespace OctoShepherd;

class OctoObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateEmptyStringParamThrowsException()
    {
        new OctoObject("", array());
        $this->assertTrue(true);
    }
    /**
     * @expectedException \InvalidArgumentException
     */
    function testInstantiateInvalidJsonParamThrowsException()
    {
        new OctoObject("i'm not valid JSON", array());
        $this->assertTrue(true);
    }
    
    function testInstantiateMinimalJsonNoExplosions()
    {
        new OctoObject("[]", array());
        $this->assertTrue(true);
    }
    
    function testExpectedKeysAccessibleAsAttributes()
    {
        $octo = new OctoObject('{"name" : "bob"}', array());
        $this->assertEquals(
            'bob',
            $octo->name,
            "Any key from the JSON string sent to constructor should be accessible as a public attribute"
        );
    }
    
    function testExpectedAttributesListReturned()
    {
        $octo = new OctoObject('{"name" : "bob", "age" : "42"}', array());
        $this->assertEquals(
            array('name' => 'bob', 'age' => '42'),
            $octo->to_array()
        );
    }
    
    function testKeyNamesAreTransformedToLowerCase()
    {
        $octo = new OctoObject('{"naMe" : "bob", "AGE" : "42"}', array());
        $this->assertEquals(
            array('name' => 'bob', 'age' => '42'),
            $octo->to_array()
        );
    }
    
    function testHasReturnsTrueForExpectedAttribute()
    {
        $octo = new OctoObject('{"name" : "bob", "age" : "42"}', array());
        $this->assertTrue($octo->has('name'));
    }
    
    function testHasReturnsFalseForUnexpectedAttribute()
    {
        $octo = new OctoObject('{"name" : "bob", "age" : "42"}', array());
        $this->assertFalse($octo->has('not_name'));
    }
    
    function testHasIsCaseInsensitive()
    {
        $octo = new OctoObject('{"name" : "bob", "age" : "42"}', array());
        $this->assertTrue($octo->has('NaMe'));
    }
    
    function testGetAttributeByNameIsCaseInsensitive()
    {
        $octo = new OctoObject('{"name" : "bob", "age" : "42"}', array());
        $this->assertEquals("bob", $octo->NaMe);
    }
    
    
    
}
