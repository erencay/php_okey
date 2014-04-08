<?
/**
 * @property int _from_row
 * @property int _from_col
 * @property int _to_row
 * @property int _to_col
 */
class MoveTileRequest extends ReceivablePacket
{
  private $_from_row;
  private $_from_col;
  private $_to_row;
  private $_to_col;

  public function implement()
  {
    $this->_from_row = $this->read_byte();
    $this->_from_col = $this->read_byte();
    $this->_to_row   = $this->read_byte();
    $this->_to_col   = $this->read_byte();
  }

  public function execute()
  {
    $this->get_player()->get_seat()->move_tile($this->_from_row, $this->_from_col, $this->_to_row, $this->_to_col);
  }

  public function error()
  {
    if(!$this->get_player()->get_room())
      return YOU_ARE_NOT_IN_A_ROOM;

    if(!$this->get_player()->get_seat())
      return YOU_ARE_NOT_PARTICIPATING_IN_THIS_GAME;

    if(!$this->get_player()->get_seat()->get_cue()->get_tile_at($this->_from_row, $this->_from_col))
      return THERE_IS_NO_TILES_IN_THIS_PLACE;

    if($this->get_player()->get_seat()->get_cue()->get_tile_at($this->_to_row, $this->_to_col))
      return YOU_CAN_NOT_PUT_ANY_TILE_HERE;

    return parent::error();
  }
}