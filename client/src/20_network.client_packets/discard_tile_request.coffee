class DiscardTileRequest extends SendablePacket
  constructor: (@row, @column)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.DISCARD_TILE_REQUEST)
    @write_byte(@row)
    @write_byte(@column)