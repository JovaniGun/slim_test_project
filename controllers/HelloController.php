<?php
namespace Controllers;
use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
class HelloController extends Controller{
    private $userModel;
    private $token;
    private $userInfo;
    /**
     * Undocumented function
     *
     * @param [type] $view
     */
    public function __construct($view){
        parent::__construct($view);
    }
    /**
     * Рендер главной страницы
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function hello(Request $request, Response $response, $args)  {
        $this->token = $_COOKIE['ID'];
        $this->userInfo = $_SESSION[$this->token];
        $session = $request->getAttribute['session'];

        $this->view->render($response, 'index.html', [
             'session_id' => $request->getCookieParams()["ID"]
         ]);
 
         return $response;
     }
}