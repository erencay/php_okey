class PlayerLeftLobby extends ReceivablePacket
  implement: (@player_id = @read_int())->

  execute: ()->
    player_id = @player_id
    $('#players_list li').filter(->$(@).data('id') == player_id).remove();