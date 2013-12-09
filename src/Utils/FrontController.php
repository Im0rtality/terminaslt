<?php


namespace Utils;


class FrontController
{
    protected $database;
    protected $modRewrite = true;
    /** @var  string */
    protected $controller;
    /** @var  string */
    protected $title;
    /** @var  string */
    protected $template;

    /** @var  HtmlHelper */
    protected $htmlHelper;
    /** @var  mixed */
    protected $templateVars = array();

    public function url($controller, $action = "", $params = "")
    {
        return $this->htmlHelper->url($controller, $action, $params);
    }

    public function __construct($modRewrite)
    {
        $this->modRewrite = $modRewrite;
    }

    /**
     * @param $config
     */
    public function initDatabase($config)
    {
        require_once $config;
        $this->database = new Database('localhost', DB_USER, DB_PASSWORD, DB_NAME);
        Auth::setDatabase($this->database);
    }

    /**
     * @param HtmlHelper $htmlHelper
     */
    public function setHtmlHelper($htmlHelper)
    {
        $this->htmlHelper = $htmlHelper;
        $this->htmlHelper->setModRewrite($this->modRewrite);
    }

    /**
     * @return bool
     */
    public function isModRewrite()
    {
        return $this->modRewrite;
    }

    public function handleRoute($route)
    {
        list($action, $sCtrl, $sClass, $ctrl, $method) = $this->loadController($route);

        if (isCallable($ctrl, $method)) {
            // call_user_func(array($ctrl, $method), $action);
            switch (count($action)) {
                case 0:
                    $this->templateVars = $ctrl->$method();
                    break;
                case 1:
                    $this->templateVars = $ctrl->$method($action[0]);
                    break;
                case 2:
                    $this->templateVars = $ctrl->$method($action[0], $action[1]);
                    break;
                case 3:
                    $this->templateVars = $ctrl->$method($action[0], $action[1], $action[2]);
                    break;
                default:
                    die("Too many parameters for {$sClass}->{$method}()");
                    break;
            }

            if ($this->templateVars === null) {
                $this->templateVars = array();
            }

            /** @var $ctrl AbstractController */
            if ($ctrl->isRenderView()) {
                $this->template = sprintf('%s/src/Views/%s/%s.php', ROOT, $sCtrl, $method);
                $this->renderTemplate($ctrl);
            }
        } else {
            die("Action '{$method}' not found in controller '{$sClass}'");
        }

    }

    public function renderView()
    {
        foreach ($this->templateVars as $key => $value) {
            $$key = $value;
        }
        require_once $this->template;
    }

    /**
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $route
     *
     * @return array
     */
    public function loadController($route)
    {
        $this->controller = isset($route['controller']) ? $route['controller'] : "";
        $action           = isset($route['action']) ? $route['action'] : "";

        $sCtrl  = empty($this->controller) ? "Home" : ucfirst($this->controller);
        $sClass = sprintf('Terminas\Controllers\%sController', $sCtrl);

        $ctrl   = new $sClass($this->database);
        $action = explode('/', $action);
        $method = array_shift($action);
        $method = empty($method) ? 'index' : strtolower($method);

        return array($action, $sCtrl, $sClass, $ctrl, $method);
    }

    /**
     * @param $ctrl
     */
    protected function renderTemplate($ctrl)
    {
        if (file_exists($this->template)) {
            $this->title = 'Terminas.lt';
            if ($ctrl->isRenderDefault()) {
                require_once ROOT . "/src/Views/Layout/default.php";
            } else {
                $this->renderView();
            }
        } else {
            die("View not found in '{$this->template}'");
        }
    }
}