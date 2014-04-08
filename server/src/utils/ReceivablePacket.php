<?
abstract class ReceivablePacket extends \MMOCore\MMOReceivablePacket
{
  /**
   * @return Client
   */
  public function get_client()
  {
    return parent::get_client();
  }

  /**
   * @return Player
   */
  public function get_player()
  {
    return $this->get_client()->get_player();
  }
}

