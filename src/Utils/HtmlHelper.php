<?php

namespace Utils;

class HtmlHelper
{
    protected $modRewrite = true;
    protected $root;

    public function url($controller, $action = "", $params = "")
    {
        $controller = (string)$controller;
        $action     = (string)$action;
        $params     = (string)$params;
        $template   = $this->modRewrite ? "%s/%s/%s/" : "index.php?controller=%s&action=%s&params=%s";
        $url        = $this->root . sprintf($template, $controller, $action, $params);
        if ($this->modRewrite) {
            $url = rtrim($url, '/') . '/';
        }
        return $url;
    }

    /**
     * @return boolean
     */
    public function isModRewrite()
    {
        return $this->modRewrite;
    }

    /**
     * @param boolean $modRewrite
     */
    public function setModRewrite($modRewrite)
    {
        $this->modRewrite = $modRewrite;
    }

    /**
     * @param string $root
     */
    public function setRoot($root)
    {
        $this->root = $root;
    }
}
