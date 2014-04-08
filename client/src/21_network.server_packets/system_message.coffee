class SystemMessage extends ReceivablePacket
  @INFO = 0x00
  @WARNING = 0x01
  @ERROR = 0x02

  implement: (@level = @read_byte(), @message = @read_string())->

  execute: ()->
    switch @level
      when SystemMessage.INFO then info @message
      when SystemMessage.WARNING then warning @message
      when SystemMessage.ERROR then error @message