class TableSeatDumped extends ReceivablePacket
  implement: (@seat_direction = @read_byte())->

  execute: ()->
    PLAYERS[@seat_direction].find('.username').text ''
    PLAYERS[@seat_direction].find('.avatar').text ''
    PLAYERS[@seat_direction].removeClass('ready busy')