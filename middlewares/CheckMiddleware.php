<?php 
namespace Middlewares;
use Slim\Http\Request;
use Slim\Http\Response;
class CheckMiddleware{

  public function __invoke(Request $request, Response $response, $next)
  {
    $cookie = $_COOKIE["ID"];
    if(isset($cookie)) // Проверка существования куки, если ее не существует, отправляем на страницу авторизации
      return $response->withRedirect('/public');
    $response = $next($request, $response);
    return $response;
  }
}