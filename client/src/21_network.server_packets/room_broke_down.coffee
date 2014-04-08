class RoomBrokeDown extends ReceivablePacket
  implement: (@room_id = @read_byte())->

  execute: ()->
    room_id = @room_id
    $('#rooms_list li').filter(->$(@).data('id') == room_id).remove()