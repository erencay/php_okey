class ChangeStage extends ReceivablePacket
  implement: (@stage = @read_byte())->

  execute: ()->
    change_stage.apply(this, STAGES[@stage])