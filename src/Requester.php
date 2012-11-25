<?php
namespace OctoShepherd;
/**
 * Created by JetBrains PhpStorm.
 * User: sam
 * Date: 11/23/12
 * Time: 1:51 PM
 * To change this template use File | Settings | File Templates.
 */
class Requester
{
    const AUTH_STRATEGY_OAUTH = 'oauth';
    const AUTH_STRATEGY_BASIC = 'http_basic';
    const HTTP_METHOD_GET    = 'get';
    const HTTP_METHOD_PUT    = 'put';
    const HTTP_METHOD_POST   = 'post';
    const HTTP_METHOD_DELETE = 'delete';

    private $base_url;
    private $end_point_path;
    private $request_method;
    private $url_params = array();
    private $last_error = array();
    /**
     * @var \Presta\Request
     */
    private $curler;

    /**
     * Assert that valid configuration items are passed to constructor then
     * set them as local attributes
     *
     * @param array $config
     * @param \Presta\Request $curler
     * @throws \InvalidArgumentException
     */
    function __construct(array $config, \Presta\Request $curler)
    {
        $this->curler = $curler;
        $this->set_auth_strategy($config);
        if( ! isset($config['base_url']) || ! $config['base_url'])
        {
            throw new \InvalidArgumentException("'base_url' must be provided in \$config param");
        }
        $this->base_url = rtrim($config['base_url'], ' /');
    }

    /**
     * @param string $endpoint_template ex: '/users/:user/starred'
     * @param string|null $zero_to_many_template_target_values a param for each target (i.e. ':user') in the $endpoint_template
     * i.e. ->get('/user/starred/:owner/:repo', $owner, $repo)
     */
    function get($endpoint_template, $zero_to_many_template_target_values = null)
    {
        $this->request_method = self::HTTP_METHOD_GET;
        $replacement_values   = $this->get_request_replacement_values(func_get_args());
        $this->end_point_path = $this->replace_targets_with_values($endpoint_template, $replacement_values);
        return $this->make_http_request();
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

    private function make_http_request()
    {
        $response = null;
        $this->curler->uri("{$this->base_url}{$this->end_point_path}{$this->get_uri_param_string()}");
        $http_response = $this->curler->get();
        if($http_response->status_code >= 400)
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

    private function replace_targets_with_values($endpoint_template, $replacement_values)
    {
        $endpoint_with_targets_replaced = "/" . trim($endpoint_template, ' /');
        preg_match_all('/(?P<targets>:[a-z-_]+)/', $endpoint_template, $matches);
        $targets_count      = count($matches['targets']);
        $replacements_count = count($replacement_values);
        if($targets_count  != $replacements_count)
        {
            throw new \InvalidArgumentException("The count of replacement values"
                . " does not match the count of replacement targets. " . PHP_EOL
                . "Url template: {$endpoint_template}" . PHP_EOL
                . "Found Targets: " . implode(', ', $matches['targets']) . " <count: {$targets_count}>" . PHP_EOL
                . "Replacement values: " . implode(', ', $replacement_values) . " <count: {$replacements_count}>");
        }
        foreach($matches['targets'] as $target_index => $target)
        {
            $endpoint_with_targets_replaced = str_replace($target, $replacement_values[$target_index], $endpoint_with_targets_replaced);
        }
        return $endpoint_with_targets_replaced;
    }

    protected function set_auth_strategy(array $config)
    {
        if( ( ! isset($config['access_token']))
            && ( ! isset($config['auth_name'], $config['auth_password']))
        )
        {
            throw new \InvalidArgumentException("Must either supply 'access_token' (oath authentication) or "
                . " 'auth_name' & 'auth_password' (simple http authentication) key/values in the \$config param");
        }
        isset($config['access_token'])
            ? $this->add_url_param('access_token', $config['access_token'])
            : $this->curler->auth($config['auth_name'], $config['auth_password']);
    }

    private function add_url_param($key, $val)
    {
        $this->url_params[$key] = $val;
    }

    private function get_uri_param_string()
    {
        $param_string = http_build_query((array)$this->url_params);
        return $param_string ? "?{$param_string}" : "";
    }

    private function get_request_replacement_values($fun_args_from_request_call)
    {
        return array_slice($fun_args_from_request_call, 1);
    }
}