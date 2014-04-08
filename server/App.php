<?
require_once 'config.php';
require_once 'lang/tr.php';
require_once './lib/mmocore/MMOCore.php';

\MMOCore\Utils::import('./src');
\MMOCore\Utils::import('./src/utils');
\MMOCore\Utils::import('./src/helpers');
\MMOCore\Utils::import('./src/entities');
\MMOCore\Utils::import('./src/network/server_packets');
\MMOCore\Utils::import('./src/network/client_packets');
\MMOCore\Utils::import('./src/network');

/**
 * @property Server _server
 * @property Lobby  _lobby
 */
class App
{
  private static $_instance;
  private $_server;
  private $_lobby;

  /**
   * @return App
   */
  public static function get_instance()
  {
    if(!self::$_instance)
      self::$_instance = new App();

    return self::$_instance;
  }

  private function __construct()
  {
    $this->_server = new Server();
    $this->_lobby  = new Lobby();
    Database::get_instance()->set_connection(DATABASE_DSN, DATABASE_USERNAME, DATABASE_PASSWORD);
  }

  public function start()
  {
    $this->_server->start(SERVER_HOST, SERVER_PORT);
  }

  /**
   * @return Server
   */
  public function get_server()
  {
    return $this->_server;
  }

  /**
   * @return Lobby
   */
  public function get_lobby()
  {
    return $this->_lobby;
  }

  final private function __clone()
  {
  }
}

App::get_instance()->start();