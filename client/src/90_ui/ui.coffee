# Disable right click
$(document).bind("contextmenu", -> false)

#Sounds
btn_snd = new Audio("assets/audio/button.wav")
$('input[type="submit"], input[type="button"]').click(-> btn_snd.play())

#System Message
error = (message)-> system_message('error', message)
info = (message)-> system_message('info', message)
warning = (message)-> system_message('warning', message)

system_message = (level, message)->
  $('#system_messages').append($('<li>').addClass(level).append($('<strong class="message">').text(message)).fadeIn(0).delay(10000).fadeOut(0))

# Stage Management
change_stage = (main, alt)->
  $(stage).hide() for stage in $('#login, #game, #login_form, #register_form, #lobby, #table')
  $(el).show() for el in [main, alt]

# Packet Inspector
dump_packet = (type, name, icon, data)->
  $('#packets .data').hide()
  $('#packets').append(
    $('<li>').addClass(type)
      .append($('<i>').addClass('icon-' + icon))
      .append($('<span class="name">').text(name).click(-> $('#packets .data').hide(); $(@).next().toggle()))
      .append($('<div class="data">').append($('<pre>').text(data.hex)).append($('<pre>').text(data.string)))
  ).parent().scrollTop(5000)

$('#expand_packets').click(->$('#packets .data').toggle())
$('#clear_packets').click(->$('#packets').empty())

# Packet Similator
$('#packet_simulator').submit(->
  try
    simulate [PacketHandler.PACKETS[$('#server_packets').val()]].concat($("#packet_builder input").map(-> $(this).val()).get())...
  catch e
    error e
  false
)

$('#server_packets')
  .change(->
    $('#packet_builder').empty()
    ($('#packet_builder').append($("<li>").append($('<label>').text(data)).append('<input type="text">')) if data.length > 0) for data in $('#server_packets :selected').data('args'))
  .append($('<option>').text(packet.name).val(code).data('args', Utils.get_arg_names(packet.prototype.implement))) for code, packet of PacketHandler.PACKETS

simulate = (constructor, data...)->
  packet = new constructor
  packet.implement.apply(packet, data)
  packet.execute()

# Login Elements
$("#login_form").submit(->Connection.get_instance().send(new LoginRequest($("#username").val(), $("#password").val())); false)
$('#to_register').click(->change_stage($('#login'), $('#register_form')))

# Register Elements
$("#register_form").submit(-> Connection.get_instance().send(new RegisterRequest($("#_username").val(), $("#_password").val(), $("#password_confirm").val())); false)
$('#to_login').click(-> change_stage($('#login'), $('#login_form')))

# Lobby
$('#create_room').click(->Connection.get_instance().send(new CreateRoomRequest()))
$('#my_avatar').click(->$('#avatars_box').toggle())

# Table Settings
$('#match_points').change(-> Connection.get_instance().send(new ChangeTableSettingRequest(ChangeTableSettingRequest.MATCH_POINTS, $(this).val())))
$('#bonus_points').change(-> Connection.get_instance().send(new ChangeTableSettingRequest(ChangeTableSettingRequest.BONUS_POINTS, $(this).val())))
$('#company_mode').change(-> Connection.get_instance().send(new ChangeTableSettingRequest(ChangeTableSettingRequest.COMPANY_MODE, $(this).val())))
$('#ready').click(-> Connection.get_instance().send(new ReadyUpRequest))
$('#score_board').click(-> Connection.get_instance().send(new ScoreBoardRequest))
$('#leave_room').click(-> Connection.get_instance().send(new LeaveRoomRequest))

# Cue
$('#cue .tile').draggable({revert: "invalid", appendTo: "#canvas", containment: '#canvas', zIndex: 99})

$("#cue .tile_holder").droppable(
  hoverClass: "hover"
  accept: -> $(@).children().length == 0
  drop: (event, ui)->
    if ui.draggable.attr('id') == 'stack_tile'
      Connection.get_instance().send(new ClaimTileFromStack(ui.draggable.parent().data('col'), ui.draggable.parent().parent().data('row')))
      $(@).append($('<span class="tile">').draggable({revert: "invalid", appendTo: "#canvas", containment: '#canvas', zIndex: 99}))
    else if ui.draggable.parent().hasClass('discard')
      Connection.get_instance().send(new ClaimTileFromDiscards(ui.draggable.parent().data('col'), ui.draggable.parent().parent().data('row')))
      $(ui.draggable).appendTo($(@)).css({top: 0, left: 0})
    else
      console.log($(@).data('col'))
      console.log($(@))
      Connection.get_instance().send(new MoveTileRequest(ui.draggable.parent().parent().data('row'), ui.draggable.parent().data('col'), $(@).parent().data('row'), $(@).data('col')))
      $(ui.draggable).appendTo($(@)).css({top: 0, left: 0})
  out: (event, ui)->
)

#Chat
$('#chat_controls').submit(-> Connection.get_instance().send(new BroadcastMessageRequest($('#chat_input').val())); $('#chat_input').val(''); false)

# Avatars
$('#avatars_list li').click(->$(this).addClass("selected").siblings().removeClass("selected"))
$('#change_avatar').click(->Connection.get_instance().send(new ChangeAvatarRequest($('#avatars_list li.selected').text())))
$('#close_avatars').click(->$('#avatars_box').hide())