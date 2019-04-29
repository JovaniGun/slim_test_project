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
 * 
 * Сначала проверяется существование куки. 
 * Сессия хранится в БД и является активной, пока существует куки
 * далее продливается время жизни куки
 */
  public function __invoke(Request $request, Response $response, $next)
  {
    $cookie = $request->getCookieParams()["ID"];
    if(!isset($cookie)) // Выкидываем на страницу авторизации, так как пользователь не авторизовался
       return $response->withRedirect('/auth'); 
    $session = SessionModel::where('session_id', $cookie)->get()->first();
    
    /**
     * обновляем время жизни куки
     */

    $response = CookieHelper::addCookie($response, "ID", $session->session_id, 60*60);
    $response = $next($request, $response);
    return $response;
  }
}