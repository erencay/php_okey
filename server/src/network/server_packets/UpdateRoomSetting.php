<?
/**
 * @property Room _room
 */
class UpdateRoomSetting extends SendablePacket
{
  private $_room;

  public function __construct($room)
  {
    $this->_room = $room;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::UPDATE_ROOM_SEAT);
    $this->write_byte($this->_room->get_id());
    $this->write_byte($this->_room->get_match_points());
    $this->write_boolean($this->_room->is_bonus_points_enabled());
    $this->write_boolean($this->_room->is_company_mode_enabled());
  }
}

