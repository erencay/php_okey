class TurnChanged extends ReceivablePacket
  implement: (@seat_direction = @read_byte())->

  execute: ()->
    if(PLAYERS[@seat_direction]).is(':visible')
      $('#turn').show().appendTo(PLAYERS[@seat_direction])
    else
      $('#turn').show().appendTo($('#cue'))