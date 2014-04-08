class RemoveTileFromCue extends ReceivablePacket
  implement: (@row = @read_byte, @column = @read_byte)->

  execute: ()->
    $($(CUE_ROWS[@row]).find('li')[@column]).empty()