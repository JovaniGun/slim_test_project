<?php

namespace Controllers;

use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\UserModel;
use Models\SessionModel;
use Helpers\CookieHelper;
use Helpers\UserHelper;

class AuthController extends Controller{
    private $userModel;
    private $cookieName = "ID";
    public function __construct($view){
        parent::__construct($view);
        $this->userModel = new UserModel();
    }
    
    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function login(Request $request, Response $response, $args){
      $post = $request->getParsedBody();
      $username = $post['username'];
      $password = UserHelper::getPasswordHash($username, $post['password']);
      $user = UserModel::where('username', $username)->get()->first();
      if(isset($user) && $user->password === $password){
        $session      = \Helpers\SessionHelper::setSession($username);
        $response = CookieHelper::addCookie($response,$this->cookieName, $session->session_id);
        // $_SESSION["user"]= [
        //   "username"  => $username,
        //   "email"     => $user->email      
        // ];
        return $response->withRedirect('/');
      }
      else{
        return $response->withRedirect('/auth');
      }
    }
    /**
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */

    public function registration(Request $request, Response $response, $args)  {
        $post = $request->getParsedBody();
        $username = $post['username'];
        $email    = $post['email'];
        $password = UserHelper::getPasswordHash($username, $post['password']);
        $errors   = [];
        if(UserHelper::checkUserHave('username',$username)){
          $errors[] = "Пользователь с таким именем уже существует";
        }
        if(UserHelper::checkUserHave('email',$email)){
          $errors[] = "Пользователь с таким email уже существует";
        }
        if(count($errors)>0){
          
          return $response->withRedirect('/auth');
        }
          $newUser = new UserModel(); //Создание нового пользователя
          $newUser->username = $username;
          $newUser->email    = $email;
          $newUser->password = $password;
          $newUser->save(); //сохранение в БД
          $session      = \Helpers\SessionHelper::setSession($username);
          $response = CookieHelper::addCookie($response, $this->cookieName, $session->session_id);
          // $_SESSION["user"]= [
          //   "username"  => $username,
          //   "email"     => $email     
          // ];
          return $response->withRedirect('/'); 

     }
     
    /**
     * Выход с аккаунта
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return void
     */
    public function logout(Request $request, Response $response, array $args){
      $session_id = $request->getCookieParams()[$this->cookieName];
      unset($_SESSION[$session_id]);
      $session = SessionModel::where('session_id', $session_id)->get()->first();
      if(isset($session)){
        $session->isLogin  = false; // записывает в базу, что пользователь вышел с сессии
        $session->save(); 
      }
      $response = CookieHelper::deleteCookie($response, $this->cookieName);
      return $response->withRedirect('/auth');
    }
}