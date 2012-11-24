<?php
namespace OctoShepherd;
/**
 * Implements the Activity context methods of the Github API context
 * @see http://developer.github.com/v3/activity
 */
class ActivityContext extends ApiContext
{

    function events()
    {
        return new Activity\EventsSubContext();
    }
    function event_types()
    {
        return new Activity\EventTypesSubContext();
    }
    function notifications()
    {
        return new Activity\NotificationsSubContext();
    }
    function starring()
    {
        return new Activity\StarringSubContext();
    }
    function watching()
    {
        return new Activity\WatchingSubContext();
    }

}