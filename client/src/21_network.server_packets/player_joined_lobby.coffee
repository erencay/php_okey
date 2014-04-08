class PlayerJoinedLobby extends ReceivablePacket
  implement: (@player_id = @read_int(), @name = @read_string())->

  execute: ()->
    $('#players_list').append($('<li>').text(@name).data('id', @player_id))