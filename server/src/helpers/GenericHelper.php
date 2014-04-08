<?
class GenericHelper
{
  /**
   * @return string
   */
  public static function generate_hash()
  {
    return sha1(uniqid(mt_rand(), TRUE));
  }

  /**
   * @param string $password
   * @param string $salt
   * @param string $hash
   *
   * @return string
   */
  public static function crypt_password($password, $salt, $hash)
  {
    return hash('sha256', $salt . $hash . $password);
  }
}

