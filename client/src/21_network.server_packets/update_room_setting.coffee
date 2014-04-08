class UpdateRoomSetting extends ReceivablePacket
  @MATCH_POINTS = 0x00
  @BONUS_POINTS = 0x01
  @COMPANY_MODE = 0x02

  implement: (@room_id = @read_byte(), @match_points = @read_byte(), @bonus_points = @read_bool(), @company_mode = @read_byte())->

  execute: ()->
    rooms_id = @room_id
    room = $('#rooms_list li').filter(->$(@).data('id') == rooms_id)
    room.find('.match_points').text(@match_points)
    room.find('.bonus_points').removeClass('on off').addClass(if @bonus_points then 'on' else 'off')
    room.find('.company_mode').removeClass('on off').addClass(if @company_mode then 'on' else 'off')