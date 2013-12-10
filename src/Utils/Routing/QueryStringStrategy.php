<?php


namespace Utils\Routing;


class QueryStringStrategy implements RoutingStrategyInterface
{

    /**
     * @param $route mixed
     *
     * @return string
     */
    public function execute($route)
    {
        return sprintf(
            'index.php?controller=%s&action=%s&params=%s',
            $route['controller'],
            $route['action'],
            $route['params']
        );
    }
}
