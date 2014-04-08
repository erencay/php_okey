<?
/**
 * @property int    _seat_direction
 * @property string _username
 * @property string _avatar
 */
class TableSeatTaken extends SendablePacket
{
  private $_seat_direction;
  private $_username;
  private $_avatar;

  /**
   * @param int    $seat_direction
   * @param string $username
   * @param string $avatar
   */
  public function __construct($seat_direction, $username, $avatar)
  {
    $this->_seat_direction = $seat_direction;
    $this->_username       = $username;
    $this->_avatar         = $avatar;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::TABLE_SEAT_TAKEN);
    $this->write_byte($this->_seat_direction);
    $this->write_string($this->_username);
    $this->write_string($this->_avatar);
  }
}

