<?
/**
 * @property Room[]   _rooms
 * @property Player[] _players
 */
class Lobby
{
  private $_rooms = array();
  private $_players = array();

  public function __construct()
  {
  }

  /**
   * @return Room[]
   */
  public function get_rooms()
  {
    return $this->_rooms;
  }

  /**
   * @param int $id
   *
   * @return Room
   */
  public function get_room($id)
  {
    return $this->_rooms[$id];
  }

  /**
   * @param Room $room
   */
  public function add_room($room)
  {
    $this->_rooms[$room->get_id()] = $room;
    $this->send_all_players(new NewRoomFounded($room));
  }

  /**
   * @param int $room_id
   */
  public function remove_room($room_id)
  {
    $this->send_all_players(new RoomBrokeDown($room_id));
    unset($this->_rooms[$room_id]);
  }

  /**
   * @return Player[]
   */
  public function get_players()
  {
    return $this->_players;
  }

  /**
   * @param $player_id
   *
   * @return Player
   */
  public function get_player($player_id)
  {
    return $this->_players[$player_id];
  }

  /**
   * @param Player $player
   */
  public function add_player($player)
  {
    foreach($this->_rooms as $room)
      $player->send(new NewRoomFounded($room));

    foreach($this->_players as $_player)
      $player->send(new PlayerJoinedLobby($_player));

    $this->_players[$player->get_id()] = $player;
    $this->send_all_players(new PlayerJoinedLobby($player));

    $player->send(new ChangeStage(PlayerStages::LOBBY));
  }

  /**
   * @param int $player_id
   */
  public function remove_player($player_id)
  {
    $this->send_all_players(new PlayerLeftLobby($player_id));
    unset($this->_players[$player_id]);
  }

  /**
   * @param SendablePacket $packet
   */
  public function send_all_players($packet)
  {
    foreach($this->_players as $player)
      $player->send($packet);
  }

  /**
   * @return int
   */
  public function get_next_room_id()
  {
    for($i = 1; $i <= count($this->_rooms); $i++)
      if(!isset($this->_rooms[$i]))
        return $i;

    return count($this->_rooms) + 1;
  }
}