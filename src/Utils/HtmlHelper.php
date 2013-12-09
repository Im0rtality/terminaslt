<?php

namespace Utils;

class HtmlHelper
{
    protected $modRewrite = true;

    public function url($controller, $action = "", $params = "")
    {
        if ($this->modRewrite) {
            return WEB_ROOT . (empty($controller) ? "" : $controller . '/') . (empty($action) ? "" : $action . '/') . (empty($params) ? "" : $params . '/');
        } else {
            return WEB_ROOT . "index.php?controller=$controller&action=$action" . (empty($params) ? "" : '/' . $params);
        }
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
}
