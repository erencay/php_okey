<?
/**
 * @property Room _room
 */
class NewRoomFounded extends SendablePacket
{
  private $_room;

  /**
   * @param Room $room
   */
  public function __construct($room)
  {
    $this->_room = $room;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::NEW_ROOM_FOUNDED);
    $this->write_byte($this->_room->get_id());

    foreach(SeatDirections::get_values() as $direction)
      if($this->_room->get_seat($direction)->get_player())
        $this->write_string($this->_room->get_seat($direction)->get_player()->get_username());
      else $this->write_string('');

    $this->write_byte($this->_room->get_match_points());
    $this->write_boolean($this->_room->is_bonus_points_enabled());
    $this->write_boolean($this->_room->is_company_mode_enabled());
  }
}

