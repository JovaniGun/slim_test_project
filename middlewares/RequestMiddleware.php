<?php 
namespace Middlewares;
use Slim\Http\Request;
use Slim\Http\Response;
class RequestMiddleware{
  public function __invoke(Request $request, Response $response, $next)
  {
    
    $response = $next($request, $response);
    if(!$request->isPost())
      return $response->withRedirect('/public');
    return $response;
  }
}