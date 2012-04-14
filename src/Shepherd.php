<?php
/**
 * Original Author: sam
 * Date: 4/14/12
 * Time: 9:58 AM
 */
namespace OctoShepherd;
use Presta\Request;
/**
 * Primary class for herding octocats
 */
class Shepherd
{
    private $attributes = array(
        'github-api-uri'     => 'https://api.github.com',
        'auth-name'          => null,
        'auth-password'      => null,
    );
    /**
     * @var \Presta\Request
     */
    private $curler;
    /**
     * @param array|null $config
     * @param null|\Presta\Request $curler Optional injected Presta curl
     * wrapper
     */
    function __construct(array $config=null, Request $curler=null)
    {
        if($config && $unknown_params = array_diff_key($config, $this->attributes))
        {
            throw new \InvalidArgumentException(
                "Unknown param key(s): ['".implode("', '", array_keys($unknown_params))."']"
                ." Known keys: ['".implode("', '", array_keys($this->attributes))."']"
            );
        }
        $this->attributes = array_merge($this->attributes, (array)$config);
        $this->curler = $curler ?: new Request(array(CURLOPT_FOLLOWLOCATION => 0));
    }
    
    function me()
    {
        return $this->curler
            ->uri("{$this->attributes['github-api-uri']}/user")
            ->auth($this->attributes['auth-name'], $this->attributes['auth-password'])
            ->get();
    }
    
    function array_dump()
    {
        return $this->attributes;
    }

}
