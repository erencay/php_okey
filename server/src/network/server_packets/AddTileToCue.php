<?
/**
 * @property int  _row
 * @property int  _col
 * @property int  _color
 * @property int  _number
 * @property bool _is_fake
 */
class AddTileToCue extends SendablePacket
{
  private $_row;
  private $_col;
  private $_color;
  private $_number;
  private $_is_fake;

  /**
   * @param int  $row
   * @param int  $col
   * @param Tile $tile
   */
  public function __construct($row, $col, $color, $number, $is_fake)
  {
    $this->_row     = $row;
    $this->_col     = $col;
    $this->_color   = $color;
    $this->_number  = $number;
    $this->_is_fake = $is_fake;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::ADD_TILE_TO_CUE);
    $this->write_byte($this->_row);
    $this->write_byte($this->_col);
    $this->write_byte($this->_color);
    $this->write_byte($this->_number);
    $this->write_boolean($this->_is_fake);
  }
}

