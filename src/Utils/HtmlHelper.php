<?php

namespace Utils;

use Utils\Routing\ModRewriteStrategy;
use Utils\Routing\QueryStringStrategy;
use Utils\Routing\RoutingHelper;

class HtmlHelper
{
    protected $root;
    /** @var RoutingHelper */
    protected $helper;

    public function __construct($modRewrite)
    {
        $this->helper = new RoutingHelper($modRewrite ? new ModRewriteStrategy() : new QueryStringStrategy());
    }

    public function url($controller, $action = "", $params = "")
    {
        return $this->root . $this->helper->executeStrategy(
            array(
                'controller' => $controller,
                'action'     => $action,
                'params'     => $params,
            )
        );
    }

    /**
     * @param string $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }
}
