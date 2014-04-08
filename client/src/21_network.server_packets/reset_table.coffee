class ResetTable extends ReceivablePacket
  implement: ()->

  execute: ()->
    el.val(null) for el in [$('match_points'), $('bonus_points'), $('company_mode')]
    $('#ready').removeClass("yes no").addClass("no").removeAttr("disabled")
    $('#canvas .tile').remove()
    $('#leader, #turn').hide();
    $('.player .username, .player .avatar, #tiles_left').text('')
    $('#ready').enable()