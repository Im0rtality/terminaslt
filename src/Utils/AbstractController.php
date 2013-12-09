<?php

namespace Utils;

class AbstractController
{
    /** @var  Database */
    protected $database;

    protected $renderDefault = true;
    protected $renderView = true;

    public function __construct($database)
    {
        $this->database = $database;
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
