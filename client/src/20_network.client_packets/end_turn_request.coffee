class EndTurnRequest extends SendablePacket
  constructor: (@pos_x, @pos_y)-> super []

  write: ()->
    @write_byte ClientPacketHeader.END_TURN_REQUEST
    @write_byte @pos_x
    @write_byte @pos_y