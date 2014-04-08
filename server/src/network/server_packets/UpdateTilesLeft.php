<?
/**
 * @property int _tiles_left
 */
class UpdateTilesLeft extends SendablePacket
{
  private $_tiles_left;

  /**
   * @param int $tiles_left
   */
  public function __construct($tiles_left)
  {
    $this->_tiles_left = $tiles_left;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::UPDATE_TILES_LEFT);
    $this->write_byte($this->_tiles_left);
  }
}