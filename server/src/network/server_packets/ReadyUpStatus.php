<?
/**
 * @property int  _seat_direction
 * @property bool _is_ready
 * @property bool _is_my_status
 */
class ReadyUpStatus extends SendablePacket
{
  private $_seat_direction;
  private $_is_ready;
  private $_is_my_status;

  /**
   * @param int  $seat_direction
   * @param bool $is_ready
   * @param bool $is_my_status
   */
  public function __construct($seat_direction, $is_ready, $is_my_status)
  {
    $this->_seat_direction = $seat_direction;
    $this->_is_ready       = $is_ready;
    $this->_is_my_status   = $is_my_status;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::READY_UP_STATUS);
    $this->write_byte($this->_seat_direction);
    $this->write_boolean($this->_is_ready);
    $this->write_boolean($this->_is_my_status);
  }
}

