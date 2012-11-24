<?php
namespace OctoShepherd;
/**
 * Implements the Starring context methods of the Github API context
 * @see http://developer.github.com/v3/activity/starring
 */
class OrgsContext extends ApiContext
{

    function events()
    {
        return $this->new_sub_context('events');
    }
    function event_types()
    {
        return $this->new_sub_context('event_types');
    }
    function notifications()
    {
        return $this->new_sub_context('notifications');
    }
    function starring()
    {
        return $this->new_sub_context('starring');
    }
    function watching()
    {
        return $this->new_sub_context('watching');
    }

    /**
     * @param $sub_context_name
     * @return ApiSubContext
     */
    private function new_sub_context($sub_context_name)
    {
        $sub_context_name = __NAMESPACE__ . "\\" . str_replace('_',  '', $sub_context_name);
        return new $sub_context_name();
    }
}