<?
/**
 * @property int    _room_id
 * @property int    _seat_direction
 * @property string _username
 */
class RoomSeatTaken extends SendablePacket
{
  private $_room_id;
  private $_seat_direction;
  private $_username;

  /**
   * @param int    $room_id
   * @param string $seat_direction
   * @param string $username
   */
  public function __construct($room_id, $seat_direction, $username)
  {
    $this->_room_id        = $room_id;
    $this->_seat_direction = $seat_direction;
    $this->_username       = $username;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::ROOM_SEAT_TAKEN);
    $this->write_byte($this->_room_id);
    $this->write_byte($this->_seat_direction);
    $this->write_string($this->_username);
  }
}

