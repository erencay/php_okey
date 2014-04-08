class ClaimTileFromStack extends SendablePacket
  constructor: (@pos_x, @pos_y)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.CLAIM_TILE_FROM_STACK)