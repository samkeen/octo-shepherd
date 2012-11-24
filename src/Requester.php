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
    private $base_url;
    private $end_point_path;
    private $curler;

    function get($endpoint_template /* [, 0 to many replacement values variables] */)
    {
        $replacement_values = $this->get_request_replacement_values(func_get_args());
        $this->end_point_path = $this->replace_targets_with_values($endpoint_template, $replacement_values);
    }

    private function replace_targets_with_values($endpoint_template, $replacement_values)
    {
        $endpoint_with_targets_replaces = $endpoint_template;
        preg_match_all('/(?P<targets>:[a-z-_]+)/', $endpoint_template, $matches);
        $targets_count = count($matches['targets']);
        $replacements_count = count($replacement_values);
        if($targets_count != $replacements_count)
        {
            throw new \InvalidArgumentException("The count of replacement values"
                . " does not match the count of replacement targets. " . PHP_EOL
                . "Url template: {$endpoint_template}" . PHP_EOL
                . "Found Targets: " . implode(', ', $matches['targets']) . " <count: {$targets_count}>" . PHP_EOL
                . "Replacement values: " . implode(', ', $replacement_values) . " <count: {$replacements_count}>");
        }
        foreach($matches['targets'] as $target_index => $target)
        {
            $endpoint_with_targets_replaces = str_replace($target, $replacement_values[$target_index], $endpoint_with_targets_replaces);
        }
        return $endpoint_with_targets_replaces;
    }
    private function get_request_replacement_values($fun_args_from_request_call)
    {
        return array_slice($fun_args_from_request_call, 1);
    }
}
