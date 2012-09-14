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
    private $response_headers = array();

    /**
     * @param string $serialized_state JSON string
     * @param array $response_headers
     * @throws \InvalidArgumentException
     */
    function __construct($serialized_state, $response_headers)
    {
        if(empty($serialized_state))
        {
            throw new \InvalidArgumentException(
                __METHOD__."  Empty value for \$serialized_state param is invalid"
            );
        }
        $this->response_headers = $response_headers;
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
    function get_header($key)
    {
        return isset($this->response_headers[$key]) ? $this->response_headers[$key] : null;
    }
    function get_headers()
    {
        return $this->response_headers;
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
