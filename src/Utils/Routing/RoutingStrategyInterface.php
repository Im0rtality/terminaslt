<?php

namespace Utils\Routing;

interface RoutingStrategyInterface
{
    /**
     * @param $route mixed
     *
     * @return string
     */
    public function execute($route);
}
