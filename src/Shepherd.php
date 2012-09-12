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
 * Primary class for herding octocats
 * @package OctoShepherd
 */
class Shepherd
{
    private $attributes = array(
        'github-api-uri' => 'https://api.github.com',
        'auth-name'      => null,
        'auth-password'  => null,
        'access_token'   => null,
    );
    /**
     * Stores the last error encountered with the guthub API
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
        $params = $params
            ? "?" . implode('&', http_build_query($params))
            : "";
        return $this->github_api_request("/users/{$user}/repos{$params}");
    }

    /**
     * Get the repos for an organization
     * 
     * @param $org_name
     * @param array $params
     * @return null|OctoObject
     */
    function get_org_repos_for($org_name, $params = array())
    {
        $params = $params
            ? "?" . implode('&', http_build_query($params))
            : "";
        return $this->github_api_request("/orgs/{$org_name}/repos{$params}");
    }

    /**
     * Returns meta for the specified Github User
     *
     * @param $username
     * @return null|OctoObject
     * @throws \InvalidArgumentException
     */
    function users($username)
    {
        if(empty($username))
        {
            throw new \InvalidArgumentException(
                __METHOD__." Empty values for param \$username is invalid"
            );
        }
        $username = urlencode($username);
        return $this->github_api_request("/users/{$username}");
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
    protected function github_api_request($endpoint)
    {
        $response = null;
        if($this->attributes['access_token'])
        {
            $this->curler
                ->uri("{$this->attributes['github-api-uri']}{$endpoint}?access_token={$this->attributes['access_token']}");
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
            $response = new OctoObject($http_response->body());
            $this->last_error = null;
        }
        return $response;
    }

}
