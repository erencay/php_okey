class UpdateTableSetting extends ReceivablePacket
  implement: (@match_points = @read_byte(), @bonus_points = @read_bool(), @company_mode = @read_bool())->

  execute: ()->
    $('#match_points').val @match_points
    $('#bonus_points').val @bonus_points
    $('#company_mode').val @company_mode