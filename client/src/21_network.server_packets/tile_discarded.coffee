class TileDiscarded extends ReceivablePacket
  implement: (@direction = @read_byte(), @color = @read_byte(), @num = @read_byte())->

  execute: ()->
    DISCARDS[parseInt(@direction)].append($('<span class="tile">').addClass(COLORS[@color]).text(@num).attr('unselectable', 'on'))