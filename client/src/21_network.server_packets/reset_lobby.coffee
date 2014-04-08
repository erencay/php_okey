class ResetLobby extends ReceivablePacket
  implement: ()->

  execute: ()->
    $('#rooms_list').empty()
    $('#players_list').empty()