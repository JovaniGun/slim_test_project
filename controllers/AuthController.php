<?php
namespace Controllers;
use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\UserModel;
use Models\SessionModel;
use Helpers\CookieHelper;

class AuthController extends Controller{
    private $userModel;
    private $cookieName = "ID";
    public function __construct($view){
        parent::__construct($view);
        $this->userModel = new UserModel();
    }

    /**
     * Функция проверки существования пользователя
     *
     * @param string $field
     * @param string $param
     * @return bool
     */
    private function checkUserHave($field,$param){
      $user = UserModel::where($field,$param)->get();
      return count($user) > 0 ? true : false;
    }

    /**
     * Функция хэширования пароля
     *
     * @param string $username
     * @param string $password
     * @return string
     */
    private function getPasswordHash($username, $password){
      return md5('pass'.md5($username.md5($password)));
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
      $password = $this->getPasswordHash($username, $post['password']);
      $user = UserModel::where('username', $username)->get()->first();
      if(isset($user) && $user->password === $password){
        //$response = CookieHelper::addCookie($response,$this->cookieName, $this->cookieName);
        $_SESSION["user"]= [
          "username"  => $username,
          "email"     => $user->email      
        ];
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
        $password = $this->getPasswordHash($username, $post['password']);
        $errors   = [];
        if($this->checkUserHave('username',$username)){
          $errors[] = "Пользователь с таким именем уже существует";
        }
        if($this->checkUserHave('email',$email)){
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
          //$response = CookieHelper::addCookie($response,$this->cookieName, $this->cookieName);
          $_SESSION["user"]= [
            "username"  => $username,
            "email"     => $email     
          ];
          var_dump($_SESSION["user"]);
          return $response->withRedirect('/'); 

     }
     /**
      * Функция гененрирует код для восстановления пароля
      *
      * @param string $email
      * @return string
      */
     private function generateCode($email){
      $time = time();
      return md5($email.$time);
     }
     /**
      * Функция создает ссылку, по которой пользователь может востановить пароль
      *
      * @param [type] $email
      * @param [type] $code
      * @return void
      */
     private function generete_restore_link($email, $code){
        
        $link = 'http://'.$_SERVER['HTTP_HOST']."/restore?code=".$code;
        return $link;
     }
     /**
      * Отправка ссылки для востановления пароля на почту
      *
      * @param Request $request
      * @param Response $response
      * @param array $args
      * @return Response
      */
     public function restore_pass(Request $request, Response $response, $args){
      $post = $request->getParsedBody();
      $email = $post['email'];
      if($this->checkUserHave('email', $email)){ // проверяется существует ли пользователь с email 
        $code = $this->generateCode($email); // генерируется код восстановления 
        $link = $this->generete_restore_link($email,$code); // генерируется ссылка
        $message = "Код востановления отправлен на почту";
        $restore = new \Models\RestoreModel(); // код восстановления для пользователя записывается в БД
        $restore->code = $code;
        $restore->email = $email;
        $restore->save();
        mail($email,"Востановление пароля", $link); // ссылка отправляется на почту
      }
      else{
        $message = "Пользователя с таким email нет";
      }
      $this->view->render($response, 'page.html', ['message' => $message]);
    }
    /**
     * Функция вызывается, когда пользователь проходит по ссылке для восстановления
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return void
     */
    public function fun_restore(Request $request, Response $response, array $args){
      $get = $request->getQueryParams(); // получаем код
      $code = $get['code'];
      $restore = \Models\RestoreModel::where('code', $code)->get()->first();
      if(!isset($restore)){ // проверка существует ли такой код в БД
        return  $this->view->render($response, 'page.html', ['message' => "Заявки нет"]);
      }
      $_SESSION['restore_email'] = $restore->email;
      return $this->view->render($response, 'restore_page.html'); // переход на вьюху для указания нового пароля
    }
    /**
     * Обновление нового пароля 
     *
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return 
     */
    public function change_password(Request $request, Response $response, array $args){
      $post = $request->getParsedBody();
      $email = $_SESSION['restore_email'];
      $password = $post['password'];
      $user = UserModel::where('email', $email)->get()->first();
      if(!isset($user)){
        return $this->view->render($response, 'page.html', ['message' => "Пользователя не существует"]);
      }
      $user->password = $this->getPasswordHash($user->username, $password);
      $user->save();
      return $this->view->render($response, 'page.html', ['message' => "Пароль успешно обновлен!"]);
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