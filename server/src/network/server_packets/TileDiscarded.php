<?
/**
 * @property int _discard_direction
 * @property int _tile_color
 * @property int _tile_number
 */
class TileDiscarded extends SendablePacket
{
  private $_discard_direction;
  private $_tile_color;
  private $_tile_number;

  /**
   * @param int $discard_direction
   * @param int $tile_color
   * @param int $tile_number
   */
  public function __construct($discard_direction, $tile_color, $tile_number)
  {
    $this->_discard_direction = $discard_direction;
    $this->_tile_color        = $tile_color;
    $this->_tile_number       = $tile_number;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::TILE_DISCARDED);
    $this->write_byte($this->_discard_direction);
    $this->write_byte($this->_tile_color);
    $this->write_byte($this->_tile_number);
  }
}

