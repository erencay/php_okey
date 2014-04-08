class DiscardedTileClaimed extends ReceivablePacket
  implement: (@at = @read_byte())->

  execute: ()->
    DISCARDS[@at].find('.tile').last().remove()