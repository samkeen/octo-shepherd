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
        $response_content_file_path = __DIR__."/{$path}.response";
        if( ! file_exists($response_content_file_path))
        {
            throw new \InvalidArgumentException("Response content file [{$response_content_file_path}] NOT found in response stubs dir");
        }
        $response_string = file_get_contents(__DIR__."/{$path}.response");
        return new \Presta\Response(
            $response_string,
            true
        );
    }
}
