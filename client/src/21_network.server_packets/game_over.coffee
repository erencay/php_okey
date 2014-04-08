class GameOver extends ReceivablePacket
  implement: (@winner = @read_string())->

  execute: ()->
    info "Oyunu #{@winner} kazandı."