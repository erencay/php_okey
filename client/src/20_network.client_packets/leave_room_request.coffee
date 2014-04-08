class LeaveRoomRequest extends SendablePacket
  constructor: ()-> super []

  write: ()->
    @write_byte(ClientPacketHeader.LEAVE_ROOM_REQUEST)