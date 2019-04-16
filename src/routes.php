<?php
use Slim\Http\Request;
use Slim\Http\Response;
use Middlewares\AuthMiddleware;
use Middlewares\CheckMiddleware;
use Middlewares\AdminCheckMiddleware;
use Middlewares\ControlMiddleware;

$app->get('/auth', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'auth.html');
})->add(new ControlMiddleware()); 
/**
 * Регистрация
 */
$app->post('/auth/registration', "AuthController:registration")->add(new ControlMiddleware());

$app->post('/auth/login', "AuthController:login")->add(new ControlMiddleware()); //Логированиe
//Рендер страницы восьановления пароля
$app->get('/auth/forgot_pass', function (Request $request, Response $response, array $args)
{
    return $this->view->render($response, 'forget_password.html');
})->add(new ControlMiddleware()); 
//генерация ссылки востановления
$app->post('/auth/restore_pass', "AuthController:restore_pass")->add(new ControlMiddleware());
//рендер формы ввода для нового пароля
$app->get('/restore',"AuthController:fun_restore")->add(new ControlMiddleware());
//обновление пароля
$app->post('/change_password',"AuthController:change_password")->add(new ControlMiddleware());
$app->get('/exit', "AuthController:logout");
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
//логирование админа
$app->post('/admin/login', "AdminController:login");
$app->get('/admin/exit',  function(Request $request, Response $response, array $args){
    unset($_SESSION["admin"]);
    return $response->withRedirect('/');
});

$app->get('/', "HelloController:hello")->add(new CheckMiddleware())->add(new AuthMiddleware());
