<?php
namespace Helpers;

class CookieHelper{

  public static function addCookie($response, $cookieName, $cookieValue, $expire = 600)
  {
    $expiry = new \DateTimeImmutable('now + '.$expire.'seconds');
    $cookie = urlencode($cookieName).'='.
    urlencode($cookieValue).'; expires='.$expiry->format(\DateTime::COOKIE).'; Max-Age=' .
    $expire . '; path=/; httponly';
    return $response->withAddedHeader('Set-Cookie', $cookie);
  }
  public static function deleteCookie($response, $cookieName, $cookieValue = '', $expire = 3600)
  {
    $expiry = new \DateTimeImmutable('now - '.$expire.'seconds');
    $cookie = urlencode($cookieName).'='.
    urlencode($cookieValue).'; expires='.$expiry->format(\DateTime::COOKIE).'; Max-Age=' .
    $expire . '; path=/; httponly';
    return $response->withAddedHeader('Set-Cookie', $cookie);
  }
}