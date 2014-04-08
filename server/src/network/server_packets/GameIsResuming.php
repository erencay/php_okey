<?
class GameIsResuming extends SendablePacket
{
  public function __construct()
  {
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::GAME_IS_RESUMING);
  }
}

