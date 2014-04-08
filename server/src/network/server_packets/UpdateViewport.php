<?
/**
 * @property int _direction
 */
class UpdatedViewport extends SendablePacket
{
  private $_direction;

  /**
   * @param Seat $seat
   */
  public function __construct($direction)
  {
    $this->_direction = $direction;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::UPDATE_VIEWPORT);
    $this->write_byte($this->_direction);
  }
}

