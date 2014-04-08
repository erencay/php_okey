<?
/**
 * @property int $_row
 * @property int $_column
 */
class RemoveTileFromCue extends SendablePacket
{
  private $_row;
  private $_column;

  /**
   * @param int $row
   * @param int $column
   */
  public function __construct($row, $column)
  {
    $this->_row    = $row;
    $this->_column = $column;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::REMOVE_TILE_FROM_CUE);
    $this->write_boolean($this->_row);
    $this->write_byte($this->_column);
  }
}

