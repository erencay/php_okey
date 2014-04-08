<?
/**
 * @property int        _id
 * @property Player     _owner
 * @property int        _mode
 * @property Tile       _indicator
 * @property Stack      _stack
 * @property Seat[]     _seats
 * @property Discard[]  _discards
 * @property int        _dealer
 * @property int        _turn
 * @property Player[]   _players
 * @property int        _match_points
 * @property bool       _bonus_points
 * @property bool       _company_mode
 * @property Scoreboard _scoreboard
 */
class Room
{
  private $_id;
  private $_owner;
  private $_mode;
  private $_indicator;
  private $_stack;
  private $_seats;
  private $_discards;
  private $_dealer;
  private $_turn;
  private $_players;
  private $_match_points;
  private $_bonus_points;
  private $_company_mode;
  private $_scoreboard;

  public function __construct($owner, $match_points = 5, $bonus_points = TRUE, $company_mode = TRUE)
  {
    $this->_id           = App::get_instance()->get_lobby()->get_next_room_id();
    $this->_owner        = $owner;
    $this->_mode         = RoomMode::PREAPARING;
    $this->_stack        = new Stack();
    $this->_match_points = $match_points;
    $this->_bonus_points = $bonus_points;
    $this->_company_mode = $company_mode;
    $this->_turn         = SeatDirections::EAST;
    $this->_dealer       = SeatDirections::SOUTH;
    $this->_scoreboard   = new Scoreboard();

    foreach(SeatDirections::get_values() as $direction)
      $this->_seats[$direction] = new Seat($this, $direction);

    foreach(DiscardDirections::get_values() as $direction)
      $this->_discards[$direction] = new Discard($direction);

    $this->player_joins($owner, SeatDirections::SOUTH);

    App::get_instance()->get_lobby()->add_room($this);
  }

  /**
   * @param Player $player
   * @param int    $seat_direction
   */
  public function player_joins($player, $seat_direction = NULL)
  {
    $player->set_room($this);
    $this->_players[$player->get_id()] = $player;

    if($seat_direction !== NULL)
      $this->_seats[$seat_direction]->take($player);

    foreach($this->_seats as $seat)
      if($seat->get_player())
        $player->send(new TableSeatTaken($seat->get_direction(), $seat->get_player()->get_username(), $seat->get_player()->get_avatar()));
      else
        $player->send(new TableSeatDumped($seat->get_direction()));

    foreach($this->_seats as $seat)
      if($seat->get_player())
        $player->send(new ReadyUpStatus($seat->get_direction(), $seat->is_ready(), $seat->get_player() == $player));

    $player->send(new ChangeStage(PlayerStages::TABLE));
    $player->send(new UpdateTableSetting($this->_match_points, $this->_bonus_points, $this->_company_mode));
    $player->send(new ChangeStage(PlayerStages::TABLE));
    $player->send(new UpdatedViewport($seat_direction ? $seat_direction : SeatDirections::SOUTH));
  }

  /**
   * @return Player
   */
  public function get_owner()
  {
    return $this->_owner;
  }

  /**
   * @param Player $player
   */
  public function set_owner($player)
  {
    $this->_owner = $player;
  }

  /**
   * @return int
   */
  public function get_mode()
  {
    return $this->_mode;
  }

  /**
   * @param int $mode
   */
  public function set_mode($mode)
  {
    $this->_mode = $mode;
  }

  /**
   * @return Tile
   */
  public function get_indicator()
  {
    return $this->_indicator;
  }

  /**
   * @param Tile $tile
   */
  public function set_indicator($tile)
  {
    $this->_indicator = $tile;
  }

  /**
   * @param int $direction
   *
   * @return Discard
   */
  public function get_discard($direction)
  {
    return $this->_discards[$direction];
  }

  /**
   * @return int
   */
  public function get_turn()
  {
    return $this->_turn;
  }

  public function change_turn()
  {
    $this->_turn = $this->_turn + 1 % 4;
    $this->send_all(new TurnChanged($this->_turn));
  }

  /**
   * @param int $player_id
   */
  public function player_left($player_id)
  {
    $player = $this->_players[$player_id];
    $player->set_room(NULL);
    $player->send(new ChangeStage(PlayerStages::LOBBY));

    if($player->get_seat())
      $player->get_seat()->drop();

    unset($this->_players[$player_id]);

    if(!$this->get_players_count())
      App::get_instance()->get_lobby()->remove_room($this->get_id());
  }

  /**
   * @return int
   */
  public function get_players_count()
  {
    return count($this->_players);
  }

  /**
   * @return int
   */
  public function get_id()
  {
    return $this->_id;
  }

  /**
   * @return int
   */
  public function get_match_points()
  {
    return $this->_match_points;
  }

  /**
   * @param int $match_points
   */
  public function set_match_points($match_points)
  {
    $this->_match_points = $match_points;
    $this->send_all(new UpdateTableSetting($this->_match_points, $this->_bonus_points, $this->_company_mode));
  }

  /**
   * @param SendablePacket $packet
   */
  public function send_all($packet)
  {
    foreach($this->get_players() as $player)
      $player->get_client()->send($packet);
  }

  /**
   * @return Player[]
   */
  public function get_players()
  {
    return $this->_players;
  }

  /**
   * @return bool
   */
  public function is_bonus_points_enabled()
  {
    return $this->_bonus_points;
  }

  /**
   * @param bool $value
   */
  public function set_bonus_points($value)
  {
    $this->_bonus_points = $value;
    $this->send_all(new UpdateTableSetting($this->_match_points, $this->_bonus_points, $this->_company_mode));
  }

  /**
   * @return bool
   */
  public function is_company_mode_enabled()
  {
    return $this->_company_mode;
  }

  /**
   * @param bool $company_mode
   */
  public function set_company_mode($company_mode)
  {
    $this->_company_mode = $company_mode;
    $this->send_all(new UpdateTableSetting($this->_match_points, $this->_bonus_points, $this->_company_mode));
  }

  public function validate_mode()
  {
    if($this->_mode == RoomMode::PREAPARING && $this->_are_seats_ready())
      $this->_start_game();

    if($this->_mode == RoomMode::RUNNING && !$this->_are_seats_ready())
      $this->_suspend_game();

    if($this->_mode == RoomMode::SUSPENDED && $this->_are_seats_ready())
      $this->_resume_game();
  }

  /**
   * @param int $direction
   *
   * @return Seat
   */
  public function get_seat($direction)
  {
    return $this->_seats[$direction];
  }

  /**
   * @return int
   */
  public function next_dealer()
  {
    return $this->_dealer = ($this->_dealer + 1) % 4;
  }

  /**
   * @return Stack
   */
  public function get_stack()
  {
    return $this->_stack;
  }

  /**
   * @param Tile $finishing_tile
   */
  public function end_turn($finishing_tile)
  {
  }

  public function broadcast_message($player_id, $message)
  {
    $this->send_all(new RoomMessageBroadcast($this->get_player($player_id)->get_username(), $message));
  }

  /**
   * @param int $player_id
   *
   * @return Player
   */
  public function get_player($player_id)
  {
    return $this->_players[$player_id];
  }

  /**
   * @return bool
   */
  private function _are_seats_ready()
  {
    foreach($this->_seats as $seat)
      if(!$seat->is_ready())
        return FALSE;

    return TRUE;
  }

  private function _start_game()
  {
    $this->_indicator = $this->_stack->init_tiles();

    foreach($this->_seats as $seat)
    {
      $tiles = $this->_stack->fetch_tiles(13);
      usort($tiles, array($this, '_sort_tiles'));

      foreach($tiles as $i => $tile)
        $seat->get_cue()->add_tile(0, $i, $tile);
    }

    $this->get_seat($this->next_dealer())->set_mode(SeatMode::DISCARDING);
    $this->set_mode(RoomMode::RUNNING);
    $this->send_all(new GameStarted());
    $this->send_all(new UpdateTilesLeft($this->get_stack()->get_tiles_left()));
    $this->send_all(new AppointIndicator($this->_indicator->get_color(), $this->_indicator->get_number()));
    $this->send_all(new TurnChanged($this->get_turn()));
  }

  private function _suspend_game()
  {
    $this->set_mode(RoomMode::SUSPENDED);
    $this->send_all(new GameSuspended());
  }

  private function _resume_game()
  {
    $this->set_mode(RoomMode::RUNNING);
    $this->send_all(new GameIsResuming());
  }

  /**
   * @param Tile $t1
   * @param Tile $t2
   *
   * @return bool
   */
  private function _sort_tiles($t1, $t2)
  {
    if($t1->is_fake() || $t2->is_fake())
      return (!$t2->is_fake() && $t1->is_fake());

    if($t1->get_color() == $t2->get_color())
      return $t1->get_number() > $t2->get_number();

    return $t1->get_color() > $t2->get_color();
  }

  private function _game_over()
  {
    $this->set_mode(RoomMode::PREAPARING);
    $this->send_all(new GameOver(''));
  }
}

class RoomSettings extends Enum
{
  const MATCH_POINTS = 0x00;
  const BONUS_POINTS = 0x01;
  const COMPANY_MODE = 0x02;
}

class RoomMode extends Enum
{
  const PREAPARING = 0x00;
  const SUSPENDED  = 0x01;
  const RUNNING    = 0x02;
}