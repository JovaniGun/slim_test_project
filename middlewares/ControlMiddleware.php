<?php 
namespace Middlewares;
use Slim\Http\Request;
use Slim\Http\Response;
class ControlMiddleware{
/**
 * Посредник не пускает залогиненых пользователей, на страницу авторизации и т.п.
 *
 * @param Request $request
 * @param Response $response
 * @param [type] $next
 * @return void
 */
  public function __invoke(Request $request, Response $response, $next)
  {
    $cookie = $request->getCookieParams()["ID"];
    if($cookie != '')
      return $response->withRedirect('/');
    $response = $next($request, $response);
    return $response;
  }
}