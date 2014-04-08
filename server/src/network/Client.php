<?
/**
 * @property Player _player
 */
class Client extends \MMOCore\MMOClient
{
  private $_player;

  public function __construct($socket)
  {
    parent::__construct($socket);
  }

  /**
   * @return Player
   */
  public function get_player()
  {
    return $this->_player;
  }

  /**
   * @param Player $player
   */
  public function set_player($player)
  {
    $this->_player = $player;
  }
}

