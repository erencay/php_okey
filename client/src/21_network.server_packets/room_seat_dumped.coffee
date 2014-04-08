class RoomSeatDumped extends ReceivablePacket
  implement: (@room_id = @read_byte(), @seat_direction = @read_byte())->

  execute: ()->
    room_id = @room_id
    seat = $('#rooms_list li').filter(->$(@).data('id') == room_id).find('.' + DIRECTIONS[@seat_direction]).val('Otur').removeAttr('disabled')