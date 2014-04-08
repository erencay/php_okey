<?
/**
 * @property string _winner
 */
class GameOver extends SendablePacket
{
  private $_winner;

  /**
   * @param string $winner
   */
  public function __construct($winner)
  {
    $this->_winner = $winner;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::GAME_OVER);
    $this->write_string($this->_winner);
  }
}
