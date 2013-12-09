<?php


namespace Utils;


class Request
{
    /** @var  ParameterBag */
    protected $post;
    /** @var  ParameterBag */
    protected $get;

    /**
     * In some place in application we are supposed to read super globals to get request params,
     * so dont throw warnings in this place.
     *
     * @SuppressWarnings(PHPMD.Superglobals)
     * @SuppressWarnings(PHPMD.CamelCaseVariableName)
     */
    public function __construct($post = null, $get = null)
    {
        $this->post = new ParameterBag(empty($post) ? $_POST : $post);
        $this->get  = new ParameterBag(empty($get) ? $_GET : $get);
    }

    public function __get($name)
    {
        switch ($name) {
            case "get":
                return $this->get;
            case "post":
                return $this->post;
        }
    }
}
