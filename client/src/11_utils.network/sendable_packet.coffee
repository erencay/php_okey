class SendablePacket extends ByteArray
  write: ()->
    throw "Yazılmamış paket."

  calculate: ()->
    @bytes.unshift(0x00, 0x00)
    @position = 0;
    @write_short(@bytes.length)

  errors: ()->
    null