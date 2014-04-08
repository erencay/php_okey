<?
/**
 * @property int    _room_id
 * @property int    _seat_direction
 */
class RoomSeatDumped extends SendablePacket
{
  private $_room_id;
  private $_seat_direction;

  /**
   * @param int    $room_id
   * @param string $seat_direction
   */
  public function __construct($room_id, $seat_direction)
  {
    $this->_room_id        = $room_id;
    $this->_seat_direction = $seat_direction;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::ROOM_SEAT_DUMPED);
    $this->write_byte($this->_room_id);
    $this->write_byte($this->_seat_direction);
  }
}

