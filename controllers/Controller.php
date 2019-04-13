<?php
namespace Controllers;


class Controller {
    protected $view;
    public function __construct($view){
        $this->view = $view;
    }
}