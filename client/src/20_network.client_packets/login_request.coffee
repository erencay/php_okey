class LoginRequest extends SendablePacket
  constructor: (@username, @password)-> super []

  write: ()->
    @write_byte(ClientPacketHeader.LOGIN_REQUEST)
    @write_string(@username)
    @write_string(@password)

  errors: ()->
    if !@username.match(/^[\w\d]{3,12}$/i)
      "Kullanıcı adı geçersiz."
    else if !@password.match(/^[\w\d]{6,16}$/i)
      "Şifre geçersiz."
    else
      super