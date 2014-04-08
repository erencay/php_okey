<?
/**
 * @property int _row
 * @property int _col
 */
class ClaimTileFromStack extends ReceivablePacket
{
  private $_row;
  private $_col;

  public function implement()
  {
    $this->_row = $this->read_byte();
    $this->_col = $this->read_byte();
  }

  public function execute()
  {
    $this->get_player()->get_seat()->claim_tile_from_stack($this->_row, $this->_col);
  }

  public function error()
  {
    if(!$this->get_player()->get_room())
      return YOU_ARE_NOT_IN_A_ROOM;

    if(!$this->get_player()->get_seat())
      return YOU_ARE_NOT_PARTICIPATING_IN_THIS_GAME;

    if(!$this->get_player()->get_seat()->get_mode() != SeatMode::CLAIMING)
      return IT_IS_NOT_TIME_FOR_CLAIMING_TILE;

    if($this->get_player()->get_seat()->get_cue()->get_tile_at($this->_row, $this->_col))
      return YOU_CAN_NOT_PUT_ANY_TILE_HERE;

    if(!$this->get_player()->get_room()->get_stack()->get_tiles_left())
      return NO_TILES_LEFT_IN_STACK;

    return parent::error();
  }
}

