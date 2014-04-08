class ReadyUpRequest extends SendablePacket
  constructor: ()-> super []

  write: ()->
    @write_byte(ClientPacketHeader.READY_UP_REQUEST)