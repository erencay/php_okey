<?
/**
 * @property ReceivablePacket[] _packets
 */
class PacketHandler implements \MMOCore\MMOPacketHandlerInterface
{
  private $_packets = array(
    0x00 => 'LoginRequest',
    0x01 => 'RegisterRequest',
    0x02 => 'ChangeAvatarRequest',
    0x03 => 'CreateRoomRequest',
    0x04 => 'ChangeTableSettingRequest',
    0x05 => 'ReadyUpRequest',
    0x06 => 'ScoreboardRequest',
    0x07 => 'LeaveRoomRequest',
    0x08 => 'MoveTileRequest',
    0x09 => 'ClaimTileFromDiscardsRequest',
    0x0A => 'ClaimTileFromStackRequest',
    0x0B => 'BroadcastMessageRequest',
    0x0C => 'DiscardTileRequest',
    0x0D => 'JoinRoomRequest',
    0x0E => 'EndTurnRequest',
    0x6F => 'PolicyFileRequest',
  );

  /**
   * @param Client                   $client
   * @param \MMOCore\SimpleByteArray $byte_array
   */
  public function read_packet($client, $byte_array)
  {
    $op_code = $byte_array->read_byte();

    if(!$class = $this->_packets[$op_code])
      return $this->_unknown_packet($op_code, $byte_array);

    /** @var ReceivablePacket $packet  */
    $packet = new $class();
    $packet->write_bytes($byte_array, $byte_array->get_position(), $byte_array->bytes_available());
    $packet->set_client($client);
    $packet->set_position(0);
    $packet->implement();

    \MMOCore\Logger::incoming_packet($packet);

    if(!$error = $packet->error())
      $packet->execute();
    else
      $client->send(new SystemMessage($error, SystemMessageLevels::ERROR));

    return TRUE;
  }

  /**
   * @param int                      $op_code
   * @param \MMOCore\SimpleByteArray $byte_array
   *
   * @return bool
   */
  private function _unknown_packet($op_code)
  {
    \MMOCore\Logger::debug("Bilinmeyen paket başlığı: {$op_code}");

    return FALSE;
  }
}

