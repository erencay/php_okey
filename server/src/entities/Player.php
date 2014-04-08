<?
/**
 * @property Client _client
 * @property int    _id
 * @property string _username
 * @property string _avatar
 * @property int    _points
 * @property int    _rank
 * @property Room   _room
 * @property Seat   _seat
 * @property int    _stage
 */
class Player
{
  private $_client;
  private $_id;
  private $_username;
  private $_avatar;
  private $_points;
  private $_rank;
  private $_room;
  private $_seat;
  private $_stage;

  public function __construct($client, $id, $username, $avatar, $points)
  {
    $this->_client   = $client;
    $this->_id       = $id;
    $this->_avatar   = $avatar;
    $this->_username = $username;
    $this->_points   = $points;
    $this->_rank     = 0;
    $this->_stage    = PlayerStages::LOBBY;
  }

  /**
   * @return int
   */
  public function get_id()
  {
    return $this->_id;
  }

  /**
   * @return string
   */
  public function get_username()
  {
    return $this->_username;
  }

  /**
   * @return string
   */
  public function get_avatar()
  {
    return $this->_avatar;
  }

  /**
   * @param string $avatar
   */
  public function set_avatar($avatar)
  {
    $this->_avatar = $avatar;
    $this->send(new UpdateMyData($avatar, $this->_username, $this->_points, $this->_rank));
  }

  /**
   * @param SendablePacket $packet
   */
  public function send($packet)
  {
    $this->get_client()->send($packet);
  }

  /**
   * @return Client
   */
  public function get_client()
  {
    return $this->_client;
  }

  /**
   * @return int
   */
  public function get_points()
  {
    return $this->_points;
  }

  /**
   * @param int $points
   */
  public function set_points($points)
  {
    $this->_points = $points;
  }

  /**
   * @return int
   */
  public function get_rank()
  {
    return $this->_rank;
  }

  /**
   * @param int $rank
   */
  public function set_rank($rank)
  {
    $this->_rank = $rank;
  }

  /**
   * @return Room
   */
  public function get_room()
  {
    return $this->_room;
  }

  /**
   * @param null|Room $room
   */
  public function set_room($room)
  {
    $this->_room = $room;
  }

  /**
   * @return Seat
   */
  public function get_seat()
  {
    return $this->_seat;
  }

  /**
   * @param Seat $seat
   */
  public function set_seat($seat)
  {
    $this->_seat = $seat;
  }

  /**
   * @return int
   */
  public function get_stage()
  {
    return $this->_stage;
  }

  /**
   * @param $stage
   */
  public function set_stage($stage)
  {
    $this->_stage = $stage;
  }

  public function __toString()
  {
    return $this->_username;
  }
}

class PlayerStages extends Enum
{
  const LOGIN_FORM    = 0x00;
  const REGISTER_FORM = 0x01;
  const LOBBY         = 0x02;
  const TABLE         = 0x03;
}