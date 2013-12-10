<?php

namespace Utils\Routing;

class RoutingHelper
{
    /** @var  RoutingStrategyInterface */
    protected $strategy;

    public function __construct(RoutingStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy($route)
    {
        return $this->strategy->execute($route);
    }
}
