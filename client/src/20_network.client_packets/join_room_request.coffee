class JoinRoomRequest extends SendablePacket
  constructor: (@room_id, @direction)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.JOIN_ROOM_REQUEST)
    @write_byte(@room_id)
    @write_byte(@direction)