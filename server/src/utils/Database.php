<?
/**
 * @static Database _instance
 *
 * @property PDO _pdo
 */
class Database
{
  private static $_instance;
  private $_pdo;

  /**
   * @return Database
   */
  public static function get_instance()
  {
    if(!self::$_instance)
      self::$_instance = new Database();

    return self::$_instance;
  }

  private function __construct()
  {
  }

  /**
   * @param string $dsn
   */
  public function set_connection($dsn, $username = NULL, $password = NULL)
  {
    try
    {
      $this->_pdo = new PDO($dsn, $username, $password);
      $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
      echo 'Bağlantı kurulamadı.' . $e->getMessage();
    }
  }

  /**
   * @return PDO
   */
  public function get_connection()
  {
    return $this->_pdo;
  }

  private function __clone()
  {
  }
}

