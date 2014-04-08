<?
class ReadyUpRequest extends ReceivablePacket
{
  public function implement()
  {
  }

  public function execute()
  {
    $this->get_player()->get_seat()->set_ready(!$this->get_player()->get_seat()->is_ready());
  }

  public function error()
  {
    if(!$this->get_player()->get_room())
      return YOU_ARE_NOT_IN_A_ROOM;

    if(!$this->get_player()->get_seat())
      return YOU_ARE_NOT_PARTICIPATING_IN_THIS_GAME;

    if($this->get_player()->get_room()->get_mode() == RoomMode::RUNNING)
      return GAME_ALREADY_BEGAN;

    return parent::error();
  }
}

