<?php 
namespace Middlewares;
use Slim\Http\Request;
use Slim\Http\Response;
class AdminCheckMiddleware{

  public function __invoke(Request $request, Response $response, $next)
  {
    if(!isset($_SESSION['admin'])) // Проверка существования куки, если ее не существует, отправляем на страницу авторизации
      return $response->withRedirect('/public');
    $response = $next($request, $response);
    return $response;
  }
}