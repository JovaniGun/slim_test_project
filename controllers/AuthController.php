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
use Helpers\Validator;

class AuthController extends Controller{
    private $userModel;
    private $cookieName = "ID";
    public function __construct($di){
        parent::__construct($di);
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
      $password = $post['password'];
      $errors = Validator::validate(['login'=>$username, 'password'=>$password]);
      if(count($errors)>0)
        return $response->withRedirect($this->router->pathFor('auth', [], $errors));
      $password = UserHelper::getPasswordHash($username, $post['password']);
      $user = UserModel::where('username', $username)->get()->first();
      if(isset($user) && $user->password === $password){
        $session      = \Helpers\SessionHelper::setSession($username);
        $response = CookieHelper::addCookie($response,$this->cookieName, $session->session_id);
        return $response->withRedirect('/');
      }
      else{
        $errors['authFail'] = "Неверный логин или пароль";
        return $response->withRedirect($this->router->pathFor('auth', [], $errors));
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
        $password = $post['password'];
        $errors   = Validator::validate(['login' => $username, 'password' => $password, 'email' => $email]);
        if(count($errors)>0)  
          return $response->withRedirect($this->router->pathFor('auth', [], $errors));
        $password = UserHelper::getPasswordHash($username, $password);

        if(UserHelper::checkUserHave('username',$username)){
          $errors[] = "Пользователь с таким именем уже существует";
        }
        if(UserHelper::checkUserHave('email',$email)){
          $errors[] = "Пользователь с таким email уже существует";
        }
        if(count($errors)>0){
          
          return $response->withRedirect($this->router->pathFor('auth', [], $errors));
        }
          $newUser = new UserModel(); //Создание нового пользователя
          $newUser->username = $username;
          $newUser->email    = $email;
          $newUser->password = $password;
          $newUser->save(); //сохранение в БД
          $session      = \Helpers\SessionHelper::setSession($username);
          $response = CookieHelper::addCookie($response, $this->cookieName, $session->session_id);
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
      \Helpers\SessionHelper::closeSession($session_id);
      $response = CookieHelper::deleteCookie($response, $this->cookieName);
      return $response->withRedirect('/auth');
    }
}