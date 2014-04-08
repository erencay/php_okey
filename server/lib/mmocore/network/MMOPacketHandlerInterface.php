<?
namespace MMOCore;

interface MMOPacketHandlerInterface
{
  /**
   * @param MMOClient       $client
   * @param SimpleByteArray $byte_array
   */
  public function read_packet($client, $byte_array);
}