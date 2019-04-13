<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Middlewares\AuthMiddleware;
use Middlewares\CheckMiddleware;
// Routes
$app->get('/auth', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'auth.twig');
})->add(new CheckMiddleware());
$app->post('/auth/registration', "AuthController:registration");
$app->post('/auth/login', "AuthController:login");

$app->get('/exit', function(Request $request, Response $response, array $args){
    setcookie("ID","",time()-3600,"/");
    unset($_SESSION);
    return $response->withRedirect('/public/auth');
});
$app->get('/[{name}]', "HelloController:hello")->add(new AuthMiddleware());
