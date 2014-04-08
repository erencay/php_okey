class ClaimATile extends ReceivablePacket
  implement: (@from = @read_byte())->

  execute: ()->
    DISCARDS[@from].find('.tile').last().draggable({revert: "invalid", appendTo: "#canvas", containment: '#canvas', zIndex: 99})
    $('#stack_tile').draggable({revert: "invalid", appendTo: "#canvas", containment: '#canvas', zIndex: 99, helper: 'clone'})