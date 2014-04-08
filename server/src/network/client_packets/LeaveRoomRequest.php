<?
class LeaveRoomRequest extends ReceivablePacket
{
  public function implement()
  {
  }

  public function execute()
  {
    $this->get_player()->get_room()->player_left($this->get_player()->get_id());
  }


  public function error()
  {
    if(!$this->get_player()->get_room())
      return YOU_ARE_NOT_IN_A_ROOM;

    return parent::error();
  }
}

