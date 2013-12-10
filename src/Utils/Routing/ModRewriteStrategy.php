<?php

namespace Utils\Routing;

class ModRewriteStrategy implements RoutingStrategyInterface
{

    /**
     * @param $route mixed
     *
     * @return string
     */
    public function execute($route)
    {
        $route = sprintf(
            "%s%s/%s/%s",
            $route['root'],
            $route['controller'],
            $route['action'],
            $route['params']
        );
        return rtrim($route, '/') . '/';
    }
}
