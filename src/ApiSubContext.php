<?php
namespace OctoShepherd;
/**
 *
 */
abstract class ApiSubContext
{
    protected $requester;

    function __construct(Requester $requester)
    {
        $this->requester = $requester;
    }

}