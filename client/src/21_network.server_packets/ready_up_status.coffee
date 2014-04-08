class ReadyUpStatus extends ReceivablePacket
  implement: (@direction = @read_byte(), @is_ready = @read_bool(), @is_my_status = @read_bool())->

  execute: ()->
    PLAYERS[@direction].removeClass('ready busy').addClass(if @is_ready then 'ready' else 'busy')
    console.log(@is_my_status)
    $('#ready').removeClass('ready busy').addClass(if @is_ready then 'ready' else 'busy') if(@is_my_status)