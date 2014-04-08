class ScoreBoardRequest extends SendablePacket
  constructor: ()-> super []

  write: ()->
    @write_byte(ClientPacketHeader.SCORE_BOARD_REQUEST)