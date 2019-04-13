<?php 
namespace Middlewares;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\UserModel;
class AuthMiddleware{

  public function __invoke(Request $request, Response $response, $next)
  {
    $cookie = $_COOKIE["ID"];
    if(!isset($cookie)) // Проверка существования куки, если ее не существует, отправляем на страницу авторизации
      return $response->withRedirect('/public/auth');
    $model = new UserModel(); 
    $user = $model->where('token', $cookie)->get()->first();
    $ip_addr = $_SERVER['REMOTE_ADDR'];  
    if(!isset($_SESSION[$cookie]))//если сессии не существует, то записываем данные пользователя с ключем номера куки
    {
      $_SESSION[$cookie] = [
        'username'    => $user->username,
        'email'       => $user->email,
        'session_id'  => $cookie,
        'role'        => $user->role,
        'ip_addr'     => $ip_addr
      ];
    }   
    /**
     * обновляем время жизни куки и обновляем токен
     */
    
    $time = time() + 60 * 60 * 24 * 30;
    $user->token = md5($user->username.$user->email.$ip_addr.$time);
    $user->ip_addr = $ip_addr;
    $user->save();
    setcookie("ID", $user->token,$time, '/', 'slim-skeleton');
    $response = $next($request, $response);
    return $response;
  }
}