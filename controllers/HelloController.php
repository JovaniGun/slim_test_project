<?php
namespace Controllers;
use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\SessionModel;
class HelloController extends Controller{
    private $cookie_val;
    private $session;
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
        $this->cookie_val = $request->getCookieParams()['ID'];
        $this->session = SessionModel::where('session_id', $this->cookie_val)->get()->first();
        $session_id = $this->session->session_id;
        //$session = $request->getAttribute['session'];
        //var_dump($session);
        $this->view->render($response, 'index.html', [
             'session_id' => $session_id
         ]);
 
         return $response;
     }
}