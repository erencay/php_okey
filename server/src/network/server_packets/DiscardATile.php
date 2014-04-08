<?
/**
 * @property int _discard_direction
 */
class DiscardATile extends SendablePacket
{
  private $_discard_direction;

  /**
   * @param int $discard_direction
   */
  public function __construct($discard_direction)
  {
    $this->_discard_direction = $discard_direction;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::DISCARD_A_TILE);
    $this->write_byte($this->_discard_direction);
  }
}