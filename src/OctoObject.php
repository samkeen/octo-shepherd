<?php
/**
 * Original Author: sam keen
 * Date: 4/14/12
 * Time: 7:50 PM
 * @package OctoShepherd
 */
namespace OctoShepherd;
/**
 * Wrapper for Github API json responses.
 * Provides getters for the response's attributes
 *
 * @package OctoShepherd
 */
class OctoObject
{
    
    private $attributes = array();

    /**
     * @param string $serialized_state JSON string
     * @throws \InvalidArgumentException
     */
    function __construct($serialized_state)
    {
        if(empty($serialized_state))
        {
            throw new \InvalidArgumentException(
                __METHOD__."  Empty value for \$serialized_state param is invalid"
            );
        }
        $this->inflate($serialized_state);        
    }

    /**
     * @param $name
     * @return mixed|null
     */
    function __get($name)
    {
        $name = strtolower($name);
        return isset($this->attributes[$name])
            ? $this->attributes[$name]
            : null;
    }
    /**
     * @param string $attribute_key
     * @return bool
     */
    function has($attribute_key)
    {
        return array_key_exists(strtolower($attribute_key), $this->attributes);
    }

    /**
     * @return array
     */
    function to_array()
    {
        return $this->attributes;
    }

    /**
     * @param $serialized_state
     * @throws \InvalidArgumentException
     */
    protected function inflate($serialized_state)
    {
        $deserialized = json_decode($serialized_state, true);
        if($deserialized===null)
        {
            throw new \InvalidArgumentException("Unable to de-serialize string: '{$serialized_state}'");
        }
        $this->attributes = array_change_key_case($deserialized, CASE_LOWER);
    }

}
