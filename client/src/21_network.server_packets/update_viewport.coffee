class UpdateViewport extends ReceivablePacket
  implement: (@viewport = @read_byte())->

  execute: ()->
    @locate_players Utils.scroll_array(PLAYERS, @viewport)
    @locate_discards Utils.scroll_array(DISCARDS, @viewport)

  locate_players: (players)->
    player.removeClass('l r t').show() for player in players
    players[0].show().hide();
    players[1].show().addClass('r')
    players[2].show().addClass('t')
    players[3].show().addClass('l')

  locate_discards: (discards)->
    discard.removeClass('b l r t') for discard in discards
    discards[0].addClass('b r');
    discards[1].addClass('t r')
    discards[2].addClass('t l')
    discards[3].addClass('b l')