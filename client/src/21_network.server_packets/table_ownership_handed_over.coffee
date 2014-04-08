class TableOwnershipHandedOver extends ReceivablePacket
  implement: (@seat = @read_byte())->

  execute: ()->
    if(PLAYERS[@seat].is(":visible"))
      $('#leader').show().appendTo(PLAYERS[@seat])
    else
      $('#leader').show().appendTo($('#cue'))