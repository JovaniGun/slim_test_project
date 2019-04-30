<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Middlewares\AuthMiddleware;
use Middlewares\CheckMiddleware;
use Middlewares\AdminCheckMiddleware;
use Middlewares\ControlMiddleware;

/**
 * Авторизация
 */

$app->get('/auth', function (Request $request, Response $response, array $args)
{
    $errors = $request->getQueryParams();
    return $this->view->render($response, 'auth.html', ['errors' => $errors]);
})->setName('auth')->add(new ControlMiddleware()); 
$app->post('/auth/registration', "AuthController:registration")->add(new ControlMiddleware());

$app->post('/auth/login', "AuthController:login")->add(new ControlMiddleware());

$app->get('/exit', "AuthController:logout");


/**
 * Востановление пароля
 */

$app->get('/auth/forgot_pass', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'forget_password.html');
})->add(new ControlMiddleware()); 
//генерация ссылки востановления
$app->post('/auth/restore_pass', "RestoreController:restore_pass")->add(new ControlMiddleware());
//рендер формы ввода для нового пароля
$app->get('/restore',"RestoreController:fun_restore")->add(new ControlMiddleware());
//обновление пароля
$app->post('/change_password',"RestoreController:change_password")->add(new ControlMiddleware());



/**
 * Админка
 */
//просмотр страницы со списком пользователей
$app->get('/admin/users', "AdminController:users")->add(new AdminCheckMiddleware());
//просмотр списка сессий
$app->get('/admin/sessions', "AdminController:sessions")->add(new AdminCheckMiddleware());
// апи для удаления пользователя
$app->delete('/admin/users/delete', "AdminController:delete");
//форма входа админки
$app->get('/admin', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'admin/auth.html');
});
$app->post('/admin/login', "AdminController:login");
$app->get('/admin/exit',  function(Request $request, Response $response, array $args){
    unset($_SESSION["admin"]);
    return $response->withRedirect('/');
});

/**
 * Главная страница
 */
$app->get('/', "HelloController:hello")->add(new AuthMiddleware());
