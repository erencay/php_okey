<?
/**
 * @property int _player_id
 */
class PlayerLeftLobby extends SendablePacket
{
  private $_player_id;

  /**
   * @param int $player_id
   */
  public function __construct($player_id)
  {
    $this->_player_id = $player_id;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::PLAYER_LEFT_LOBBY);
    $this->write_int($this->_player_id);
  }
}

