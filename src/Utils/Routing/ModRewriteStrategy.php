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
        return rtrim(sprintf("%s/%s/%s", $route['controller'], $route['action'], $route['params']), '/') . '/';
    }
}
