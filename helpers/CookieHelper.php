<?php
namespace Helpers;

class CookieHelper{
  /**
   * создание куки
   *
   * @param Response $response
   * @param string $cookieName
   * @param string $cookieValue
   * @param integer $expire
   * @return void
   */
  public static function addCookie($response, $cookieName, $cookieValue, $expire = 600)
  {
    $expiry = new \DateTimeImmutable('now + '.$expire.'seconds');
    $cookie = urlencode($cookieName).'='.
    urlencode($cookieValue).'; expires='.$expiry->format(\DateTime::COOKIE).'; Max-Age=' .
    $expire . '; path=/; httponly';
    return $response->withAddedHeader('Set-Cookie', $cookie);
  }
  /**
   * Удаление куки
   *
   * @param Response $response
   * @param string $cookieName
   * @param string $cookieValue
   * @param integer $expire
   * @return void
   */
  public static function deleteCookie($response, $cookieName, $cookieValue = '', $expire = 3600*24)
  {
    $expiry = new \DateTimeImmutable('now - '.$expire.'seconds');
    $cookie = urlencode($cookieName).'='.
    urlencode($cookieValue).'; expires='.$expiry->format(\DateTime::COOKIE).'; Max-Age=' .
    $expire . '; path=/; httponly';
    return $response->withAddedHeader('Set-Cookie', $cookie);
  }
}