<?php 

namespace Controllers;

use Slim\Views\Twig;
use Illuminate\Database\Query\Builder;
use Slim\Http\Request;
use Slim\Http\Response;
use Models\UserModel;
use Helpers\UserHelper;

class RestoreController extends Controller
{
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
        if(UserHelper::checkUserHave('email', $email)){ // проверяется существует ли пользователь с email 
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
        $user->password = UserHelper::getPasswordHash($user->username, $password);
        $user->save();
        return $this->view->render($response, 'page.html', ['message' => "Пароль успешно обновлен!"]);
      }
}