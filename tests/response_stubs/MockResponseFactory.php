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
        $response_string = file_exists(__DIR__."/{$path}.response")
            ? file_get_contents(__DIR__."/{$path}.response")
            : file_get_contents(__DIR__."/404.response");
        return new \Presta\Response(
            $response_string,
            true
        );
    }
}
