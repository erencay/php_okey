class BroadcastMessageRequest extends SendablePacket
  constructor: (@message)-> super []

  write: ()->
    @write_byte ClientPacketHeader.BROADCAST_MESSAGE_REQUEST
    @write_string @message

  errors: ()->
    if $.trim(@message = $.trim(@message)).length  == 0 then 'Boş mesaj gönderemezsiniz.' else super