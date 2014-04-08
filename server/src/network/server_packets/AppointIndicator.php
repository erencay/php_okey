<?
/**
 * @property int _color
 * @property int _number
 */
class AppointIndicator extends SendablePacket
{
  private $_color;
  private $_number;

  /**
   * @param int $color
   * @param int $number
   */
  public function __construct($color, $number)
  {
    $this->_color = $color;
    $this->_number = $number;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::APPOINT_INDICATOR);
    $this->write_byte($this->_color);
    $this->write_byte($this->_number);
  }
}

