class NewRoomFounded extends ReceivablePacket
  implement: (@room_id = @read_byte(), @south = @read_string(), @east = @read_string(), @north = @read_string(), @west = @read_string(), @match_points = @read_byte(), @bonus_points = @read_bool(), @company = @read_bool())->

  execute: ()->
    $('#rooms_list')
      .append(
        $('<li>')
          .data('id', @room_id)
          .append($('<span class="room_id">').text('#' + @room_id))
          .append(@add_seat(@room_id, 0x00, @south))
          .append(@add_seat(@room_id, 0x01, @east))
          .append(@add_seat(@room_id, 0x02, @north))
          .append(@add_seat(@room_id, 0x03, @west))
          .append($('<span class="match_points">').addClass('on').text(@match_points))
          .append($('<span class="bonus_points">').addClass(if(@bonus_points) then 'on' else 'off').text('G'))
          .append($('<span class="company_mode">').addClass(if(@company) then 'on' else 'off').text('E'))
      )

  add_seat: (room_id, direction, holder)->
    seat = $('<input type="button" class="seat">').addClass(DIRECTIONS[direction])

    if holder
      seat.attr("disabled", true).val(holder)
    else
      seat.val('Otur').click(-> Connection.get_instance().send(new JoinRoomRequest(room_id, direction)))