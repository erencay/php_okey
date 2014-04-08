<?
/**
 * @property int _room_id
 * @property int _seat_direction
 */
class JoinRoomRequest extends ReceivablePacket
{
  private $_room_id;
  private $_seat_direction;

  public function implement()
  {
    $this->_room_id        = $this->read_byte();
    $this->_seat_direction = $this->read_byte();
  }

  public function execute()
  {
    App::get_instance()->get_lobby()->get_room($this->_room_id)->player_joins($this->get_player(), $this->_seat_direction);
  }

  public function error()
  {
    if($this->get_player()->get_room())
      return YOU_ARE_ALREADY_IN_A_ROOM;

    if(!App::get_instance()->get_lobby()->get_room($this->_room_id))
      return ROOM_DOES_NOT_EXIST;

    if(!App::get_instance()->get_lobby()->get_room($this->_room_id)->get_seat($this->_seat_direction))
      return INVALID_SEAT;

    if(App::get_instance()->get_lobby()->get_room($this->_room_id)->get_seat($this->_seat_direction)->get_player())
      return THIS_SEAT_ALREADY_TAKEN;

    return parent::error();
  }
}

