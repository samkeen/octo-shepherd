<?php
namespace OctoShepherd\Activity;
/**
 * Implements the Activity/Starring context methods of the Github API context
 * @see http://developer.github.com/v3/activity/starring
 */
class StarringSubContext extends \OctoShepherd\ApiSubContext
{

    /**
     * GET /repos/:owner/:repo/stargazers/
     *
     * @see http://developer.github.com/v3/activity/starring/#list-stargazers
     *
     * @param string $owner
     * @param string $repo
     */
    function get_repo_stargazers($owner, $repo)
    {
        return $this->requester->get('/repos/:owner/:repo/stargazers/', $owner, $repo);
    }

    /**
     * GET /users/:user/starred
     *
     * @see http://developer.github.com/v3/activity/starring/#list-repositories-being-starred
     *
     * @param $user
     */
    function get_repos_starred_by_user($user)
    {

    }

    /**
     * GET /user/starred
     *
     * @see http://developer.github.com/v3/activity/starring/#list-repositories-being-starred
     */
    function get_repos_starred_by_me()
    {

    }

    /**
     * GET /user/starred/:owner/:repo
     *
     * @see http://developer.github.com/v3/activity/starring/#check-if-you-are-starring-a-repository
     *
     * @param $owner
     * @param $repo
     */
    function get_is_repo_starred_by_me($owner, $repo)
    {

    }

    /**
     * PUT /user/starred/:owner/:repo
     *
     * @see http://developer.github.com/v3/activity/starring/#star-a-repository
     *
     * @param $owner
     * @param $repo
     */
    function put_repo_star($owner, $repo)
    {

    }

    /**
     * DELETE /user/starred/:owner/:repo
     *
     * @see http://developer.github.com/v3/activity/starring/#unstar-a-repository
     *
     * @param $owner
     * @param $repo
     */
    function delete_repo_star($owner, $repo)
    {

    }
}