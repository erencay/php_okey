<?
/**
 * @property Discard _discard
 */
class ClaimATile extends SendablePacket
{
  private $_discard;

  public function __construct($discard)
  {
    $this->_discard = $discard;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::CLAIM_A_TILE);
    $this->write_byte($this->_discard->get_direction());
  }
}
