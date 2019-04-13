<?php
namespace Controllers;
use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\UserModel;
use Slim\Http\Cookies;
class AuthController extends Controller{
    private $userModel;
    public function __construct($view){
        parent::__construct($view);
        $this->userModel = new UserModel();
    }
    private function checkUserHave($field,$param){
      $user = $this->userModel->where($field,$param)->get();
      return count($user) > 0 ? true : false;
    }
    private function getToken($username, $email, $ip, $time){
      return md5($username.$email.$ip.$time);
    }
    private function getPasswordHash($username, $password){
      return md5('pass'.md5($username.md5($password)));
    }
    public function login(Request $request, Response $response, $args){
      $post = $request->getParsedBody();
      $username = $post['username'];
      $password = $this->getPasswordHash($username, $post['password']);
      $user = UserModel::where('username', $username)->get()->first();
      $ip_addr = $_SERVER['REMOTE_ADDR'];
      if(isset($user) && $user->password === $password){
        $cookieTime = time() + 60 * 60 * 24 * 30;
        $user->token = $this->getToken($username, $email, $ip_addr,$cookieTime);
        $user->save();
        setcookie("ID", $user->token, $cookieTime,'/','slim-skeleton');
        return $response->withRedirect('/public');
      }
      else{
        return $response->withRedirect('/public/auth');
      }
    }
    public function registration(Request $request, Response $response, $args)  {
        $post = $request->getParsedBody();
        $username = $post['username'];
        $email    = $post['email'];
        $password = $this->getPasswordHash($username, $post['password']);
        $errors   = [];
        $cookies = new Cookies();
        if($this->checkUserHave('username',$username)){
          $errors[] = "Пользователь с таким именем уже существует";
        }
        if($this->checkUserHave('email',$email)){
          $errors[] = "Пользователь с таким email уже существует";
        }
        if(count($errors)>0){
          
          return $response->withRedirect('/public/auth');
        }
        else{
          $newUser = new UserModel();
          $newUser->username = $username;
          $newUser->email    = $email;
          $newUser->password = $password;
          $ip_addr = $_SERVER['REMOTE_ADDR'];
          $cookieTime = time() + 60 * 60 * 24 * 30;
          $newUser->token = $this->getToken($username, $email, $ip_addr,$cookieTime);
          $newUser->save();
          setcookie("ID", $newUser->token, $cookieTime,'/','slim-skeleton');
          return $response->withRedirect('/public');
        }        
     }
}