<?
/**
 * @property string _avatar
 * @property string _username
 * @property int    _points
 * @property int    _rank
 */
class UpdateMyData extends SendablePacket
{
  private $_avatar;
  private $_username;
  private $_points;
  private $_rank;

  /**
   * @param string $avatar
   * @param string $username
   * @param int    $points
   * @param int    $rank
   */
  public function __construct($avatar, $username, $points, $rank)
  {
    $this->_avatar   = $avatar;
    $this->_username = $username;
    $this->_points   = $points;
    $this->_rank     = $rank;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::UPDATE_MY_DATA);
    $this->write_string($this->_avatar);
    $this->write_string($this->_username);
    $this->write_int($this->_points);
    $this->write_int($this->_rank);
  }
}

