class AddTileToCue extends ReceivablePacket
  implement: (@row = @read_byte(), @column = @read_byte(), @color = @read_byte(), @number = @read_byte(), @is_fake = @read_bool())->

  execute: ()->
    tile = $('<span class="tile">')
      .addClass(COLORS[@color])
      .text(if @isfake then '!' else @number)
      .attr('unselectable', 'on')
      .draggable({revert: "invalid", appendTo: "#canvas", containment: '#canvas', zIndex: 99})

    $($(CUE_ROWS[@row]).find('li')[@column]).empty().append(tile)