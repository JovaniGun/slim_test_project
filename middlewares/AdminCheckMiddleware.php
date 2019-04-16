<?php 
namespace Middlewares;
use Slim\Http\Request;
use Slim\Http\Response;
class AdminCheckMiddleware{

  /**
   * Посредник проверяет заглогинен ли админ
   *
   * @param Request $request
   * @param Response $response
   * @param [type] $next
   * @return void
   */
  public function __invoke(Request $request, Response $response, $next)
  {
    if(!isset($_SESSION['admin']))
      return $response->withRedirect('/');
    $response = $next($request, $response);
    return $response;
  }
}