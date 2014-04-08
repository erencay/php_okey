<?
class Server extends \MMOCore\MMOServer
{
  public function __construct()
  {
    parent::__construct(new PacketHandler());
  }

  public function start($host, $port)
  {
    parent::start($host, $port);
  }

  protected function add_client($socket)
  {
    $client                            = new Client($socket);
    $this->_clients[$client->get_id()] = $client;
  }

  /**
   * @param Client $client
   */
  protected function remove_client($client)
  {
    if($client->get_player())
      $this->_remove_player($client->get_player());

    parent::remove_client($client);
  }

  /**
   * @param Player $player
   */
  private function _remove_player($player)
  {
    App::get_instance()->get_lobby()->remove_player($player->get_id());

    if($player->get_room())
      $player->get_room()->player_left($player->get_id());
  }
}

