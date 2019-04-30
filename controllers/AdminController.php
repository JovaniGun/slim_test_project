<?php
namespace Controllers;
use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\AdminModel;
use Models\UserModel;
use Models\SessionModel;
class AdminController extends Controller{
    public function __construct($di){
        parent::__construct($di);
    }
    /**
     * Вход в админ панель 
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response $response
     */
    public function login(Request $request, Response $response, $args){
      $post     = $request->getParsedBody();
      $login    = $post['login'];
      $password = $post['password'];
      $admin     = AdminModel::where('login', $login)->get()->first();
      if(isset($admin) && $admin->password === $password){
        $_SESSION["admin"] = ['login' => $admin->login];
        return $response->withRedirect('/admin/users');
      }
      else{
        return $response->withRedirect('/admin/auth');
      }
    }
    /**
     * Получение списка пользователей
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function users(Request $request, Response $response, $args)
    {
      $users = UserModel::all();
      $this->view->render($response, 'admin/show_users.html', ['users' => $users]);
      return $response;
    }
    /**
     * Получение списка сессий
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function sessions(Request $request, Response $response, $args)
    {
      $sessions = SessionModel::all();
      $this->view->render($response, 'admin/show_sessions.html', ['sessions' => $sessions]);
      return $response;
    }
    /**
     * Удаление пользователя
     *
     * @param Request $request
     * @param Response $response
     * @param [type] $args
     * @return void
     */
    public function delete(Request $request, Response $response, $args){
      $post = $request->getParsedBody();
      $id   = $post['id'];
      $user = UserModel::find($id);
      $user->delete();
      return $response;
    }
}