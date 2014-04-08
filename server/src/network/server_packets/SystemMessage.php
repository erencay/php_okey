<?
/**
 * @property int    _level
 * @property string _message
 */
class SystemMessage extends SendablePacket
{
  private $_level;
  private $_message;

  /**
   * @param int    $level
   * @param string $message
   */
  public function __construct($message, $level)
  {
    $this->_level   = $level;
    $this->_message = $message;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::SYSTEM_MESSAGE);
    $this->write_byte($this->_level);
    $this->write_string($this->_message);
  }
}

class SystemMessageLevels extends Enum
{
  const INFO    = 0x00;
  const WARNING = 0x01;
  const ERROR   = 0x02;
}

