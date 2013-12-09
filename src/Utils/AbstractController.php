<?php

namespace Utils;

class AbstractController
{
    /** @var  Database */
    protected $database;
    /** @var  Request */
    protected $request;

    protected $renderDefault = true;
    protected $renderView = true;

    /**
     * @param $database Database
     * @param $request  Request
     */
    public function __construct(Database $database, Request $request)
    {
        $this->database = $database;
        $this->request  = $request;
    }

    /**
     * @return boolean
     */
    public function isRenderDefault()
    {
        return $this->renderDefault;
    }

    /**
     * @return boolean
     */
    public function isRenderView()
    {
        return $this->renderView;
    }
}
