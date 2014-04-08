<?
namespace MMOCore;

abstract class MMOSendablePacket extends MMOPacketAbstract
{
  abstract function write();

  public function calculate()
  {
    $packet_length = $this->length() + 2;

    array_unshift($this->_bytes, $packet_length >> 0 & 0xFF);
    array_unshift($this->_bytes, $packet_length >> 8 & 0xFF);
  }
}