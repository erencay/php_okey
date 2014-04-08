<?
/**
 * @property int _seat_direction
 */
class TurnChanged extends SendablePacket
{
  private $_seat_direction;

  /**
   * @param int $seat_direction
   */
  public function __construct($seat_direction)
  {
    $this->_seat_direction = $seat_direction;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::TURN_CHANGED);
    $this->write_byte($this->_seat_direction);
  }
}

