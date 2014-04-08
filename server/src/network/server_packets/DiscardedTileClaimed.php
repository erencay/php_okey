<?
/**
 * @property Discard _discard
 */
class DiscardedTileClaimed extends SendablePacket
{
  private $_discard;

  public function __construct($discard)
  {
    $this->_discard = $discard;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::DISCARDED_TILE_CLAIMED);
    $this->write_byte($this->_discard->get_direction());
  }
}
