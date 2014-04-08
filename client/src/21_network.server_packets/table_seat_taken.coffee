class TableSeatTaken extends ReceivablePacket
  implement: (@seat_direction = @read_byte(), @username = @read_string(), @avatar = @read_string())->

  execute: ()->
    PLAYERS[@seat_direction].find('.username').text @username
    PLAYERS[@seat_direction].find('.avatar').text @avatar
    PLAYERS[@seat_direction].addClass('busy')