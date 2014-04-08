<?
class CreateRoomRequest extends ReceivablePacket
{
  public function implement()
  {
  }

  public function execute()
  {
    new Room($this->get_player());
  }

  public function error()
  {
    if($this->get_player()->get_room())
      return YOU_ARE_ALREADY_IN_A_ROOM;

    return parent::error();
  }
}

