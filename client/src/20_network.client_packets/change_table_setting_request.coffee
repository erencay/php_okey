class ChangeTableSettingRequest extends SendablePacket
  @MATCH_POINTS = 0x00
  @BONUS_POINTS = 0x01
  @COMPANY_MODE = 0x02

  constructor: (@type, @value)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.CHANGE_TABLE_SETTING_REQUEST)
    @write_byte(@type)
    @write_byte(@value)

  errors: ()->
    value = @value
    switch true
      when $.inArray(@type, [0x00, 0x01, 0x02]) < 0 then "Bilinmeyen ayar '#{@type}'."
      when @type == 0x00 and $.inArray(parseInt(value), [5, 7, 9, 11]) < 0 then "Geçersiz maç puanı '#{value}'."
      when @type == 0x01 and $.inArray(parseInt(value), [0, 1]) < 0 then "Geçersiz gösterge ayarı '#{value}'."
      when @type == 0x02 and $.inArray(parseInt(value), [0, 1]) < 0 then "Geçersiz eş ayarı '#{value}'."
      else
        super