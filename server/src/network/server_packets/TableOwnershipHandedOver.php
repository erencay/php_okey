<?
/**
 * @property Seat _seat
 */
class TableOwnershipHandedOver extends SendablePacket
{
  private $_seat;

  public function __construct($seat)
  {
    $this->_seat = $seat;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::TABLE_OWNERSHIP_HANDED_OVER);
    $this->write_byte($this->_seat->get_direction());
  }
}

