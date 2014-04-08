class ByteArray
  position: 0

  constructor: (@bytes = [])->

  length: ()->
    @bytes.length

  bytes_available: ()->
    @length() - @position

  read_byte: ()->
    @read_next()

  read_bytes: (byte_array, position = 0, length = 0)->
    byte_array.position = position
    byte_array.write_byte(@read_byte()) i for i in [0...length]

  read_bool: ()->
    @read_byte() == 0x01

  read_short: ()->
    i = @read_next() << 8;
    i += @read_next() << 0;

  read_int: ()->
    i = this.read_next() << 24;
    i += this.read_next() << 16;
    i += this.read_next() << 8;
    i += this.read_next() << 0;

  read_string: ()->
    string = ''
    string += String.fromCharCode(next) while next = @read_byte() if(@bytes_available())
    string

  read_next: ()->
    throw 'Satır sonu' if(!@bytes_available())
    @bytes[@position++] & 0xFF;

  write_byte: (val)->
    @bytes[@position++] = val >> 0;

  write_bytes: (source, position, limit)->
    source.position = position;
    @write_byte(source.read_byte()) for i in [0...limit]

  write_bool: (val)->
    @bytes[@position++] = if(val) then 0x01 else 0x00

  write_short: (val)->
    @bytes[@position++] = val >> 8 & 0xFF;
    @bytes[@position++] = val >> 0 & 0xFF;

  write_int: (val)->
    @bytes[@position++] = val >> 24 & 0xFF;
    @bytes[@position++] = val >> 16 & 0xFF;
    @bytes[@position++] = val >> 8 & 0xFF;
    @bytes[@position++] = val >> 0 & 0xFF;

  write_string: (val)->
    chr_array = val.split('');
    @write_byte(chr.charCodeAt(0)) for chr in chr_array
    @write_byte(0x00);

  to_string: ()->
    hex_array = (ByteArray.dec_to_hex(i) for i in @bytes)
    hex_string = (ByteArray.hex_to_str(i) for i in @bytes)
    {hex: hex_array.join(' ').replace(/([^\0]{48})/g, '$1\n'), string: hex_string.join(' ').replace(/([^\0]{48})/g, '$1\n')}

  to_array: ()->
    return @bytes;

  @dec_to_hex: (dec)->
    if(dec == null) then hex_value = '  ' else hex_value = ("0" + (Number(dec).toString(16))).slice(-2).toUpperCase()

  @hex_to_str: (hex)->
    if(hex >= 32 && hex <= 126) then String.fromCharCode(hex) + ' ' else '. ';
