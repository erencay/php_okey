class Connection
  @_instace = null

  _packet_handler: new PacketHandler()
  _timer: null,

  @get_instance: ()->
    @_instance ?= new @()

  constructor: ()->

  connect: (host, port)->
    @_call('connect', host, port)

  on_connect: (evt)->
    info "Bağlantı kuruldu."
    clearInterval(@_timer)

  on_disconnect: (evt)->
    warning "Bağlantı kapandı."
    @_timer = setTimeout => @retry() 3000

  on_read_data: (data)->
    @_packet_handler.read(new ByteArray(data))

  on_io_error: (evt)->
    error "G/Ç hatası."

  on_security_error: (evt)->
    error "Güvenlik hatası."

  send: (packet)->
    errors = packet.errors()

    if(errors == null)
      packet.write()
      packet.calculate()
      @_call('send_packet', packet.to_array())
      dump_packet('outgoing', packet.constructor.name, 'upload-alt', packet.to_string())
    else
      error errors

  retry: ()->
    warning "Tekrar bağlanıyor..."
    @_call('connect')

  _call: (func, args...)->
    try
      document.getElementById("connection")[func].apply(null, args)
    catch e
      error e