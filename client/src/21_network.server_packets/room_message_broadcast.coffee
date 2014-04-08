class RoomMessageBroadcast extends ReceivablePacket
  implement: (@username = @read_string(), @message = @read_string())->

  execute: ()->
    $('#broadcasts')
      .append($('<li>').append($('<strong class="username">').text(@username + ':')).append($('<span class="message">').text(@message)).fadeIn(500).delay(10000).fadeOut(500))