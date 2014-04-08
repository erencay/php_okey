class RegisterRequest extends SendablePacket
  constructor: (@username, @password, @password_confirm)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.REGISTER_REQUEST)
    @write_string(@username)
    @write_string(@password)
    @write_string(@password_confirm)

  errors: ()->
    if !@username.match(/^[\w\d]{4,16}$/i)
      "Kullanıcı adı geçersiz."
    else if !@password.match(/^[\w\d]{4,16}$/i)
      "Şifre geçersiz."
    else if @password != @password_confirm
      "Şifreler uyuşmuyor"
    else
      super