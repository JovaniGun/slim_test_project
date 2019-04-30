<?php
namespace Helpers;

class Validator
{
  private static $templates = [
    'login' => "#^[A-Za-zА-Яа-я0-9@-_\$&\#]{6,15}$#",
    'email' => "#^([A-Za-z0-9-_\$]+)@([a-z]+)\.([a-z]+)$#",
    'password' => "#^([A-Za-zА-Яа-я0-9@-_\$&\#]{6,})$#"
  ]; 
  private static $messages = [
    'login'     => "Неверный формат логина",
    'email'     => "Неверный формат email",
    'password'  => "Неверный формат пароля"
  ];
  /**
   * Undocumented function
   *
   * @param array $params
   * @return void
   */
  public static function validate($params = [])
  {
    $errors = [];
    foreach ($params as $key => $value) {
      if(!preg_match(self::$templates[$key],$value))
      {
        $errors[$key] = self::$messages[$key];
      }
    }
    return $errors;
    
  }
}