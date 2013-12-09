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
    /** @var  string */
    protected $action;
    /** @var  Request */
    protected $request;
    /** @var  string */
    protected $controllerName;
    /** @var  string */
    protected $method;

    public function url($controller, $action = "", $params = "")
    {
        return $this->htmlHelper->url($controller, $action, $params);
    }

    public function __construct($modRewrite, $request)
    {
        $this->modRewrite = $modRewrite;
        $this->request    = $request;
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
        $ctrl = $this->loadController($route);
        $this->buildAction($route);
        $this->buildMethod();

        if (isCallable($ctrl, $this->method)) {
            $this->templateVars = call_user_func_array(array($ctrl, $this->method), $this->action);

            if ($this->templateVars === null) {
                $this->templateVars = array();
            }

            /** @var $ctrl AbstractController */
            if ($ctrl->isRenderView()) {
                $this->template = sprintf('%s/src/Views/%s/%s.php', ROOT, $this->controllerName, $this->method);
                $this->renderTemplate($ctrl);
            }
        } else {
            throw new \Exception("Action '{$this->method}' not found in controller '" . get_class($ctrl) . "'");
        }
    }

    public function renderView()
    {
        if (!empty($this->template)) {
            foreach ($this->templateVars as $key => $value) {
                $$key = $value;
            }
            require_once $this->template;
        }
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
     * @return AbstractController
     */
    public function loadController($route)
    {
        $this->controller     = isset($route['controller']) ? $route['controller'] : "";
        $this->controllerName = empty($this->controller) ? "Home" : ucfirst($this->controller);
        $sClass               = sprintf('Terminas\Controllers\%sController', $this->controllerName);
        $ctrl                 = new $sClass($this->database, $this->request);

        return $ctrl;
    }

    /**
     * @param $ctrl AbstractController
     *
     * @throws \Exception
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
            throw new \Exception("View not found in '{$this->template}'");
        }
    }

    protected function buildMethod()
    {
        $this->method = array_shift($this->action);
        $this->method = empty($this->method) ? 'index' : strtolower($this->method);
    }

    /**
     * @param $route
     */
    protected function buildAction($route)
    {
        $this->action = isset($route['action']) ? $route['action'] : "";
        $this->action = explode('/', $this->action);
    }
}
