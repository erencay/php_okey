<?
class ResetTable extends SendablePacket
{
  public function __construct()
  {
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::RESET_TABLE);
  }
}

