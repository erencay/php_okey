class MoveTileRequest extends SendablePacket
  constructor: (@from_row, @from_column, @to_row, @to_column)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.MOVE_TILE_REQUEST)
    @write_byte(@from_row)
    @write_byte(@from_column)
    @write_byte(@to_row)
    @write_byte(@to_column)