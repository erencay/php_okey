<?
namespace MMOCore;

abstract class MMOReceivablePacket extends MMOPacketAbstract
{
  abstract function implement();

  abstract function execute();

  /**
   * @return bool
   */
  public function before_execute()
  {
    return TRUE;
  }

  /**
   * @return null|string
   */
  public function error()
  {
    return NULL;
  }
}