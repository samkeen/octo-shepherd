<?php
/**
 * Original Author: sam keen
 * Date: 4/14/12
 * Time: 9:58 AM
 * @package OctoShepherd
 */
namespace OctoShepherd;
use Presta\Request;
/**
 * The core API functionality class
 *
 * $api = new Api();
 * $star_gazers = $api->activity->starring->get_repo_stargazers($owner, $repo);
 *
 * @package OctoShepherd
 */
class Api
{
    private $attributes = array(
        'github-api-uri'    => 'https://api.github.com',
        'auth-name'         => null,
        'auth-password'     => null,
        'app_client_id'     => null,
        'app_client_secret' => null,
        'access_token'      => null,
    );
    /**
     * Stores the last error encountered with the github API
     * i.e.
     * array(
     *   'status_code'   => $http_response->status_code,
     *   'status_label'  => $http_response->status_label,
     *   'error_message' => $error_message,
     * )
     *
     * @var array
     */
    private $last_error = null;
    /**
     * @var \Presta\Request
     */
    private $curler;
    /**
     * @param array|null $config
     * @param null|\Presta\Request $curler Optional injected Presta curl
     * wrapper
     * @throws \InvalidArgumentException
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

    function activity()
    {
        return new ActivityContext();
    }
    function gists()
    {
        return new GistsContext();
    }
    function git_data()
    {
        return new GitContext();
    }
    function issues()
    {
        return new IssuesContext();
    }
    function orgs()
    {
        return new OrgsContext();
    }
    function pull_requests()
    {
        return new PullContext();
    }
    function repositories()
    {
        return new RepositoriesContext();
    }
    function users()
    {
        return new UsersContext();
    }
    function search()
    {
        return new SearchContext();
    }
    function markdown()
    {
        return new MarkdownContext();
    }


    /**
     * Generate the auth request URI
     * @see http://developer.github.com/v3/oauth/#web-application-flow
     *
     * @param string $client_id
     * @param string $state
     * @param array $scopes
     * @return string
     */
    static function auth_request_uri($client_id, $state, $scopes=array())
    {
        $scopes = $scopes ? '&scope=' . implode(',',(array)$scopes) : "";
        return "https://github.com/login/oauth/authorize?client_id={$client_id}&state={$state}{$scopes}";
    }

    /**
     * Generate a unguessable single use state string to be used for Auth requests
     * @see http://developer.github.com/v3/oauth/#web-application-flow
     *
     * @return string
     */
    static function generate_state_string()
    {
        return uniqid(mt_rand(1,999999));
    }

    function exchange_auth_code_for_access_token($app_state_value, $response_state_value, $auth_code)
    {
        $access_token = null;
        if( ! $this->attributes['app_client_id'] || ! $this->attributes['app_client_secret'])
        {
            throw new \ErrorException("app_client_id and/or app_client_secret not set."
                . "@see http://developer.github.com/v3/oauth/"
            );
        }
        if($app_state_value != $response_state_value)
        {
            throw new \ErrorException(
                "Oauth recorded app state and response app state values did not match "
                    . "'{$app_state_value}' != '{$response_state_value}'"
                    . "@see http://developer.github.com/v3/oauth/"
            );
        }
        if( ! $auth_code)
        {
            throw new \ErrorException("Oauth, auth code was empty.  Need a valid auth code to exchange for an access token"
                . "@see http://developer.github.com/v3/oauth/");
        }
        $access_token = $this->access_token_request($auth_code, $app_state_value);
        return $access_token;
    }

    /**
     * Calls API to return meta on the API logged in user
     *
     * @return null|OctoObject
     */
    function me()
    {
        return $this->github_api_request('/user');
    }

    /**
     * Get the repos for the authenticated user
     *
     * @return null|OctoObject
     */
    function get_my_repos()
    {
        return $this->github_api_request('/user/repos');
    }

    /**
     * Get the public repos for the given github user
     *
     * @param $user
     * @param array $params
     * @return null|OctoObject
     */
    function get_user_public_repos_for($user, $params = array())
    {
        return $this->github_api_request("/users/{$user}/repos" . $this->build_param_string($params));
    }

    /**
     * Get the repos for an organization
     * 
     * @param $org_name
     * @param array $params
     * @return null|OctoObject
     */
    function get_all_org_repos($org_name, $params = array())
    {
        return $this->github_api_request("/orgs/{$org_name}/repos" . $this->build_param_string($params));
    }

    /**
     * @param $user_name
     * @param $repo_name
     * @param array $params
     * @return null|OctoObject
     */
    function list_branches($user_name, $repo_name, $params = array())
    {
        //GET /repos/:user/:repo/branches
        return $this->github_api_request(
            "/repos/{$user_name}/{$repo_name}/branches" . $this->build_param_string($params));
    }

    /**
     * @param array $params
     * @return string
     */
    protected function build_param_string($params)
    {
        return $params
            ? "?" . implode('&', http_build_query((array)$params))
            : "";
    }

    /**
     * @param $user_name
     * @param $repo_name
     * @param $branch_name
     * @param array $params
     * @return null|OctoObject
     */
    function get_branch($user_name, $repo_name, $branch_name, $params = array())
    {
        //GET /repos/:user/:repo/branches/:branch
        $params = $params
            ? "?" . implode('&', http_build_query($params))
            : "";
        return $this->github_api_request("/repos/{$user_name}/{$repo_name}/branches/{$branch_name}{$params}");
    }

    /**
     * @param string $user
     * @param string $repo_name
     * @param array $params
     * @return null|OctoObject
     */
    function get_tags($user, $repo_name, $params = array())
    {
        // GET /repos/:user/:repo/tags
        return $this->github_api_request("/repos/{$user}/{$repo_name}/tags" . $this->build_param_string($params));
    }
    /**
     * Returns meta for the specified Github User
     *
     * @param $username
     * @return null|OctoObject
     * @throws \InvalidArgumentException
     */
//    function users($username)
//    {
//        if(empty($username))
//        {
//            throw new \InvalidArgumentException(
//                __METHOD__." Empty values for param \$username is invalid"
//            );
//        }
//        $username = urlencode($username);
//        return $this->github_api_request("/users/{$username}");
//    }

    function get_path($user, $repo, $path, $params=array())
    {
        $path = trim($path, ' /');
//        $params['path'] = $path;
        // GET /repos/:user/:repo/contents/:path
        $params = $params
            ? "?" . http_build_query($params)
            : "";
        return $this->github_api_request("/repos/{$user}/{$repo}/contents/{$path}{$params}");
    }

    /**
     * Utility for debugging
     *
     * @return array
     */
    function array_dump()
    {
        return $this->attributes;
    }

    /**
     * Returns the last error encountered by the API
     * @see $this->last_error
     *
     * @return array|null
     */
    function last_error()
    {
        return $this->last_error;
    }

    /**
     * Make the API request to the given $endpoint.
     *
     * @param $endpoint
     * @return null|OctoObject
     */
    function github_api_request($endpoint)
    {
        $response = null;
        if($this->attributes['access_token'])
        {
            $access_token_key = strstr($endpoint, '?') ? '&access_token=' : '?access_token=';
            $this->curler
                ->uri("{$this->attributes['github-api-uri']}{$endpoint}{$access_token_key}{$this->attributes['access_token']}");
        }
        else
        {
            $this->curler
                ->uri("{$this->attributes['github-api-uri']}{$endpoint}")
                ->auth($this->attributes['auth-name'], $this->attributes['auth-password']);

        }
        $http_response = $this->curler->get();
        if($http_response->status_code != '200')
        {
            $error_details = (array)json_decode($http_response->body(), true);
            $error_message = isset($error_details['message']) ? $error_details['message'] : '';
            $this->last_error = array(
                'status_code'   => $http_response->status_code,
                'status_label'  => $http_response->status_label,
                'error_message' => $error_message,
            );
        }
        else
        {
            $response = new OctoObject($http_response->body(), $http_response->headers());
            $this->last_error = null;
        }
        return $response;
    }

    protected function access_token_request($auth_code, $auth_state)
    {
        $result = $this->curler
            ->uri('https://github.com/login/oauth/access_token')
            ->headers(array('Accept: application/json'))
            ->post(
            array(
                'client_id'     => $this->attributes['app_client_id'],
                'client_secret' => $this->attributes['app_client_secret'],
                'code'          => $auth_code,
                'state'         => $auth_state
            )
        );
        $response = json_decode($result->body(), true);
        if( ! $response)
        {
            throw new \ErrorException("unable to json decode access token response: ".$result->body());
        }
        if( ! isset($response['access_token']))
        {
            throw new \ErrorException("Attempted to exchange the auth code for a Access Token, "
                    . "but was unable to parse the access_token from the response. "
                    . "The parsed JSON response was: <pre>" .print_r($response, true)
                    . "</pre>"
            );
        }
        return $response['access_token'];
    }

}
