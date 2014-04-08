<?
/**
 * @property string _message
 */
class BroadcastMessageRequest extends ReceivablePacket
{
  private $_message;

  public function implement()
  {
    $this->_message = $this->read_string();
  }

  public function execute()
  {
    $this->get_player()->get_room()->broadcast_message($this->get_player()->get_id(), $this->_message);
  }

  public function error()
  {
    if(!strlen(trim($this->_message)))
      return YOU_CAN_NOT_SEND_EMPTY_MESSAGE;

    if(!$this->get_player()->get_room())
      return YOU_ARE_NOT_IN_A_ROOM;

    return parent::error();
  }
}

