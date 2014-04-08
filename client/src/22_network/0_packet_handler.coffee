class PacketHandler
  @PACKETS = []
  @PACKETS[0x00] = AddTileToCue
  @PACKETS[0x01] = AppointIndicator
  @PACKETS[0x02] = ChangeStage
  @PACKETS[0x03] = ClaimATile
  @PACKETS[0x04] = DiscardATile
  @PACKETS[0x05] = DiscardedTileClaimed
  @PACKETS[0x07] = NewRoomFounded
  @PACKETS[0x08] = PlayerJoinedLobby
  @PACKETS[0x09] = PlayerLeftLobby
  @PACKETS[0x0A] = ReadyUpStatus
  @PACKETS[0x0B] = ResetTable
  @PACKETS[0x0C] = RoomBrokeDown
  @PACKETS[0x0E] = RoomMessageBroadcast
  @PACKETS[0x0F] = Scoreboard
  @PACKETS[0x10] = TableOwnershipHandedOver
  @PACKETS[0x11] = TileDiscarded
  @PACKETS[0x12] = TurnChanged
  @PACKETS[0x13] = UpdateMyData
  @PACKETS[0x15] = UpdateRoomSetting
  @PACKETS[0x17] = UpdateTilesLeft
  @PACKETS[0x18] = UpdateViewport
  @PACKETS[0x1C] = UpdateTableSetting
  @PACKETS[0x1E] = SystemMessage
  @PACKETS[0x1F] = ResetLobby
  @PACKETS[0x20] = TableSeatTaken
  @PACKETS[0x21] = TableSeatDumped
  @PACKETS[0x22] = RoomSeatTaken
  @PACKETS[0x23] = RoomSeatDumped
  @PACKETS[0x24] = RemoveTileFromCue
  @PACKETS[0x25] = GameStarted
  @PACKETS[0x26] = GameSuspended
  @PACKETS[0x27] = GameIsResuming
  @PACKETS[0x28] = GameOver

  read: (byte_array)->
    code = byte_array.read_byte()

    if(PacketHandler.PACKETS[code])
      packet = new PacketHandler.PACKETS[code]()
      packet.write_bytes(byte_array, byte_array.position, byte_array.bytes_available());
      packet.position = 0;
      packet.implement();

      try
        packet.execute();
      catch e
        error e

      dump_packet('incoming', packet.constructor.name, 'download-alt', packet.to_string())
    else
      dump_packet('unknown', 'Bilinmeyen Paket [0x' + ByteArray.dec_to_hex(code) + ']', 'upload-alt', byte_array.to_string())