<?
namespace MMOCore;

/**
 * @property MMOClient $_client
 */
abstract class MMOPacketAbstract extends SimpleByteArray
{
  private $_client;

  /**
   * @return MMOClient
   */
  public function get_client()
  {
    return $this->_client;
  }

  /**
   * @param MMOClient $client
   */
  public function set_client($client)
  {
    $this->_client = $client;
  }
}