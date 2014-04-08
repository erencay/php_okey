class ChangeAvatarRequest extends SendablePacket
  constructor: (@avatar)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.CHANGE_AVATAR_REQUEST)
    @write_string(@avatar)

  errors: ()->
    if !@avatar.match(/^[qazwsx]{1}$/) then "Geçersiz resim." else null