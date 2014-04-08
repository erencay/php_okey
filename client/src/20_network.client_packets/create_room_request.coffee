class CreateRoomRequest extends SendablePacket
  constructor: ()-> super []

  write: ()->
    @write_byte(ClientPacketHeader.CREATE_ROOM_REQUEST)