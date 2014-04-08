class RoomSeatTaken extends ReceivablePacket
  implement: (@room_id = @read_byte(), @seat_direction = @read_byte(), @username = @read_string())->

  execute: ()->
    room_id = @room_id
    seat = $('#rooms_list li').filter(->$(@).data('id') == room_id).find('.' + DIRECTIONS[@seat_direction]).val(@username).attr('disabled', true)