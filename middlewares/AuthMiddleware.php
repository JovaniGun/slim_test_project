<?php 
namespace Middlewares;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Models\SessionModel;
use Models\UserModel;
use Helpers\CookieHelper;
class AuthMiddleware{
/**
 * Посредник проверяет, существует ли сессия, да - продлевает жизнь куки, нет - записывает новую сессию 
 *
 * @param Request $request
 * @param Response $response
 * @param [type] $next
 * @return Response $response
 */
  public function __invoke(Request $request, Response $response, $next)
  {
    $cookie = $request->getCookieParams()["ID"];
    $localSession = $_SESSION['user'];// сессия существует, когда пользователь только что авторизовался
    if(!isset($cookie) && !isset($localSession)) // Выкидываем на страницу авторизации, так как пользователь не авторизовался
       return $response->withRedirect('/auth'); 
    $session = SessionModel::where('session_id', $cookie)->get()->first();
    // if(!isset($session))//если сессии не существует, то записываем данные пользователя с ключем номера куки
    // {
    //     $localSession = $_SESSION['user'];
    //     $session      = \Helpers\SessionHelper::setSession($localSession['username']);  
    // }
    $request = $request->withAttribute('session', [
        'id'      => $session->session_id,
        'user'    => $session->user,
        'ip_addr' => $session->ip_addr
      ]);
      
    /**
     * обновляем время жизни куки
     */

    $response = CookieHelper::addCookie($response, "ID", $session->session_id, 60*60);
    $response = $next($request, $response);
    return $response;
  }
}