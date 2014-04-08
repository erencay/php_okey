<?
/**
 * @property int _room_id
 */
class RoomBrokeDown extends SendablePacket
{
  private $_room_id;

  /**
   * @param int $room_id
   */
  public function __construct($room_id)
  {
    $this->_room_id = $room_id;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::ROOM_BROKE_DOWN);
    $this->write_byte($this->_room_id);
  }
}
