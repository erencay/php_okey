class UpdateTilesLeft extends ReceivablePacket
  implement: (@tiles_left = @read_byte())->

  execute: ()->
    $('#tiles_left').text(@tiles_left)