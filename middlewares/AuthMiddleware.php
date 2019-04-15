<?php 
namespace Middlewares;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Models\SessionModel;
use Models\UserModel;
use Helpers\CookieHelper;
class AuthMiddleware{
/**
 * Undocumented function
 *
 * @param Request $request
 * @param Response $response
 * @param [type] $next
 * @return Response $response
 */
  public function __invoke(Request $request, Response $response, $next)
  {
    $cookie = $request->getCookieParams()["ID"];

    if(isset($cookie)) // Проверка существования куки, если ее не существует, отправляем на страницу авторизации
    {  
      $ip_addr = $_SERVER['REMOTE_ADDR'];  
      $session = SessionModel::where('session_id',$cookie)->get()->first();
      if(!isset($session))//если сессии не существует, то записываем данные пользователя с ключем номера куки
      {
        $localSession = $_SESSION['user'];
        $session = new SessionModel();
        $session->session_id = md5(mt_rand().$localSession['username']);
        $session->user  = $localSession['username'];
        $session->ip_addr  = $ip_addr;
        $session->isLogin  = true;
        $session->save(); 
        
      }
      $request = $request->withAttribute('session', [
        'id'      => $session->session_id,
        'ip_addr' => $session->ip_addr
      ]);
      
    /**
     * обновляем время жизни куки
     */
      $response = CookieHelper::addCookie($response, "ID", $session->session_id, 60*60);
    }
    $response = $next($request, $response);
    return $response;
  }
}