<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Middlewares\AuthMiddleware;
use Middlewares\CheckMiddleware;
use Middlewares\AdminCheckMiddleware;
use Middlewares\ControlMiddleware;
// Routes
$app->get('/auth', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'auth.html');
})->add(new ControlMiddleware());
$app->post('/auth/registration', "AuthController:registration")->add(new ControlMiddleware());
$app->post('/auth/login', "AuthController:login")->add(new ControlMiddleware());
$app->get('/auth/forgot_pass', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'forget_password.html');
})->add(new ControlMiddleware());
$app->post('/auth/restore_pass', "AuthController:restore_pass")->add(new ControlMiddleware());
$app->get('/exit', "AuthController:logout");

$app->get('/restore',"AuthController:fun_restore")->add(new ControlMiddleware());
$app->post('/change_password',"AuthController:change_password")->add(new ControlMiddleware());

//$app->get('/admin', "AdminController:main")->add(new AdminCheckMiddleware());
$app->get('/admin/users', "AdminController:users")->add(new AdminCheckMiddleware());
$app->get('/admin/sessions', "AdminController:sessions")->add(new AdminCheckMiddleware());
$app->delete('/admin/users/delete', "AdminController:delete");


$app->get('/admin', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'admin/auth.html');
});
$app->get('/admin/exit',  function(Request $request, Response $response, array $args){
    unset($_SESSION["admin"]);
    return $response->withRedirect('/public');
});
$app->post('/admin/login', "AdminController:login");
$app->get('/', "HelloController:hello")->add(new CheckMiddleware())->add(new AuthMiddleware());
