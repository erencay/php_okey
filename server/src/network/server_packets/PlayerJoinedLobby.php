<?
/**
 * @property Player _player
 */
class PlayerJoinedLobby extends SendablePacket
{
  private $_player;

  /**
   * @param Player $player
   */
  public function __construct($player)
  {
    $this->_player = $player;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::PLAYER_JOINED_LOBBY);
    $this->write_int($this->_player->get_id());
    $this->write_string($this->_player->get_username());
  }
}

