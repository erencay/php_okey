class AppointIndicator extends ReceivablePacket
  implement: (@color = @read_byte(), @num = @read_byte())->

  execute: ()->
    $('#indicator').removeClass(COLORS.join(' ')).addClass(COLORS[@color]).text(@num)