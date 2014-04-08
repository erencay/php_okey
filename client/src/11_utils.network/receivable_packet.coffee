#require utils/byte_array

class ReceivablePacket extends ByteArray
  implement: ()->
    throw 'Okunmamış paket.'

  execute: ()->
    throw 'İşlenmemiş paket'