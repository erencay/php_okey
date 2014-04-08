class UpdateMyData extends ReceivablePacket
  implement: (@avatar = @read_string(), @username = @read_string(), @points = @read_int(), @rank = @read_int())->

  execute: ()->
    $('#my_avatar').text(@avatar)
    $('#my_username').text(@username)
    $('#my_points').text(@points)
    $('#my_rank').text(@rank)