class DiscardATile extends SendablePacket
  implement: (@to = @read_byte())->

  execute: ()->
    $('#stack_tile.ui-draggable, .discard .ui-draggable').draggable('destroy');

    DISCARDS[@to].droppable(
      hoverClass: "hover",
      disabled: false,
      drop: (event, ui)->
        $(ui.draggable).appendTo($(@)).css({top: 0, left: 0})
        Connection.get_instance().send(new DiscardTileRequest(ui.draggable.parent().parent().data('row')), ui.draggable.parent().data('col'))
    )

    $('#indicator').droppable(
      hoverClass: "hover",
      disabled: false,
      drop: (event, ui)->
        ui.draggable.css({top: 0, left: 0})
        Connection.get_instance().send(new EndTurnRequest(ui.draggable.parent().parent().data('row')), ui.draggable.parent().data('col'))
    )