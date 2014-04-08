<?
/**
 * @property string _username
 * @property string _message
 */
class RoomMessageBroadcast extends SendablePacket
{
  private $_username;
  private $_message;

  /**
   * @param string $username
   * @param string $message
   */
  public function __construct($username, $message)
  {
    $this->_username = $username;
    $this->_message  = $message;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::ROOM_MESSAGE_BROADCAST);
    $this->write_string($this->_username);
    $this->write_string($this->_message);
  }
}


