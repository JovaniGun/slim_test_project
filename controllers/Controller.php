<?php
namespace Controllers;


class Controller {
    protected $di;
    protected $view;
    protected $router;
    public function __construct($di){
        $this->di = $di;
        $this->view = $this->di->get('view');
        $this->router = $this->di->get('router');
    }
}