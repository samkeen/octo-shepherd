<?php
/**
 * Original Author: sam
 * Date: 4/14/12
 * Time: 10:57 AM
 */
namespace OctoShepherd;
/**
 * 
 */
class MockResponseFactory
{
    static function response($path)
    {
        return new \Presta\Response(
            file_get_contents(__DIR__."/{$path}.response"),
            true
        );
    }
}
