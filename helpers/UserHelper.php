<?php 

namespace Helpers;

use Models\UserModel;
class UserHelper{

     /**
     * Функция проверки существования пользователя
     *
     * @param string $field
     * @param string $param
     * @return bool
     */
  public static function checkUserHave($field,$param){
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
    public static function getPasswordHash($username, $password){
      return md5('pass'.md5($username.md5($password)));
    }
}