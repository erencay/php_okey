<?
/**
 * @property int _stage
 */
class ChangeStage extends SendablePacket
{
  private $_stage;

  /**
   * @param int $stage
   */
  public function __construct($stage)
  {
    $this->_stage = $stage;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::CHANGE_STAGE);
    $this->write_byte($this->_stage);
  }
}

