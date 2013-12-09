<?php


namespace Utils;


class Request
{
    /** @var  ParameterBag */
    protected $post;
    /** @var  ParameterBag */
    protected $get;

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
