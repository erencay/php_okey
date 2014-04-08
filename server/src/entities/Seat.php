<?
/**
 * @property Room   _room
 * @property int    _direction
 * @property Cue    _cue
 * @property Player _player
 * @property bool   _is_ready
 * @property bool   _mode
 */
class Seat
{
  private $_room;
  private $_direction;
  private $_cue;
  private $_player;
  private $_is_ready;
  private $_mode;

  /**
   * @param Room   $room
   * @param int    $direction
   * @param Player $player
   */
  public function __construct($room, $direction, $player = NULL)
  {
    $this->_room      = $room;
    $this->_direction = $direction;
    $this->_player    = $player;
    $this->_is_ready  = FALSE;
    $this->_mode      = SeatMode::WAITING;
    $this->_cue       = new Cue($this);
  }

  /**
   * @return Room
   */
  public function get_room()
  {
    return $this->_room;
  }

  /**
   * @return int
   */
  public function get_direction()
  {
    return $this->_direction;
  }

  /**
   * @return Cue
   */
  public function get_cue()
  {
    return $this->_cue;
  }

  /**
   * @return Player
   */
  public function get_player()
  {
    return $this->_player;
  }

  /**
   * @param Player $player
   */
  public function take($player)
  {
    $this->_player = $player;
    $player->set_seat($this);

    $this->get_room()->send_all(new TableSeatTaken($this->_direction, $this->_player->get_username(), $this->_player->get_avatar()));
    App::get_instance()->get_lobby()->send_all_players(new RoomSeatTaken($this->_room->get_id(), $this->_direction, $this->_player->get_username()));
  }

  public function drop()
  {
    $this->_player->set_seat(NULL);
    $this->_player = NULL;

    if($this->get_room()->get_mode() == RoomMode::RUNNING)
      $this->set_mode(RoomMode::SUSPENDED);

    $this->get_room()->send_all(new TableSeatDumped($this->_direction));
    App::get_instance()->get_lobby()->send_all_players(new RoomSeatDumped($this->_room->get_id(), $this->_direction));
  }

  /**
   * @return bool
   */
  public function is_ready()
  {
    return $this->_is_ready;
  }

  /**
   * @param bool $is_ready
   */
  public function set_ready($is_ready)
  {
    $this->_is_ready = $is_ready;

    $this->get_room()->send_all(new ReadyUpStatus($this->_direction, $this->_is_ready, TRUE));
    $this->get_room()->validate_mode();
  }

  /**
   * @return bool
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

    if($mode == SeatMode::DISCARDING)
      $this->get_player()->send(new DiscardATile($this->get_direction()));
  }

  /**
   * @param int $row
   * @param int $column
   */
  public function claim_tile_from_discard($row, $column)
  {
    $tile = $this->get_room()->get_discard(($this->_direction + 3) % 4)->claim_tile();

    $this->get_cue()->add_tile($this->$row, $column, $tile);
    $this->set_mode(SeatMode::DISCARDING);
  }

  /**
   * @param int $row
   * @param int $column
   */
  public function claim_tile_from_stack($row, $column)
  {
    $tile = $this->get_room()->get_stack()->get_last();

    $this->get_cue()->add_tile($this->$row, $column, $tile);
    $this->set_mode(SeatMode::DISCARDING);
  }

  /**
   * @param int $row
   * @param int $column
   */
  public function discard_tile($row, $column)
  {
    $tile = $this->get_cue()->get_tile_at($row, $column);

    $this->get_room()->get_discard($this->get_direction())->add_tile($tile);
    $this->get_room()->send_all(new TileDiscarded($this->get_direction(), $tile->get_color(), $tile->get_number()));
    $this->get_room()->change_turn();

    $this->set_mode(SeatMode::WAITING);
  }

  public function try_to_finish_turn($row, $column)
  {
    $finishing_tile = $this->get_cue()->remove_tile($row, $column);

    if($this->get_cue()->has_valid_hand())
      $this->get_room()->end_turn($finishing_tile);
    else
    {
      $this->get_cue()->add_tile($row, $column, $finishing_tile);
      $this->get_player()->send(new SystemMessage(YOUR_HAND_IS_NOT_VALID, SystemMessageLevels::WARNING));
    }
  }

  public function move_tile($from_row, $from_column, $to_row, $to_column)
  {
    $tile = $this->get_cue()->remove_tile($from_row, $from_column);
    $this->get_cue()->add_tile($to_row, $to_column, $tile);
  }
}

class SeatDirections extends Enum
{
  const SOUTH = 0x00;
  const EAST  = 0x01;
  const NORTH = 0x02;
  const WEST  = 0x03;
}

class SeatMode extends Enum
{
  const WAITING    = 0x00;
  const CLAIMING   = 0x01;
  const DISCARDING = 0x02;
}