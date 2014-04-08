<?
namespace MMOCore;

/**
 * @property string                    $_host
 * @property int                       $_port
 * @property MMOClient[]               $_clients
 * @property MMOPacketHandlerInterface $_packet_handler
 */
class MMOServer
{
  private $_server_socket;
  private $_host;
  private $_port;
  private $_packet_handler;
  protected $_clients = array();

  public function __construct($packet_handler)
  {
    $this->_server_socket = socket_create(AF_INET, SOCK_STREAM, 0);
    socket_set_option($this->_server_socket, SOL_SOCKET, SO_REUSEADDR, 0);
    socket_set_option($this->_server_socket, SOL_SOCKET, SO_KEEPALIVE, 0);
    socket_set_option($this->_server_socket, SOL_SOCKET, SO_RCVTIMEO, array('sec'  => 1, 'usec' => 0));
    socket_set_nonblock($this->_server_socket);

    $this->_packet_handler = $packet_handler;
  }

  /**
   * @param string $host
   * @param int    $port
   */
  public function start($host, $port)
  {
    $this->_host = $host;
    $this->_port = $port;

    $this->run();
  }

  public function stop()
  {
    socket_close($this->_server_socket);
  }

  protected function run()
  {
    socket_bind($this->_server_socket, $this->_host, $this->_port) or die('Port kullanimda.');
    socket_listen($this->_server_socket) or die('Belirtilen port dinlenemiyor.');

    Logger::debug("Sunucu {$this->_host}:{$this->_port} uzerinde dinlemeye basladi.");

    while(TRUE)
    {
      if($socket = @socket_accept($this->_server_socket))
        if(is_resource($socket))
          $this->add_client($socket);

      usleep(1000);

      foreach($this->_clients as $client)
        $this->read_input_stream($client);
    }
  }

  /**
   * @param $socket
   */
  protected function add_client($socket)
  {
    $client                            = new MMOClient($socket);
    $this->_clients[$client->get_id()] = $client;
  }

  /**
   * @param MMOClient $client
   */
  protected  function remove_client($client)
  {
    unset($this->_clients[$client->get_id()]);
    $this->_clients = array_filter($this->_clients);
  }

  /**
   * @param MMOClient $client
   */
  private function read_input_stream($client)
  {
    $input = $client->read();

    if($input === '')
      $this->remove_client($client->close());
    else
      $this->read_packet($client, $input);
  }

  /**
   * @param MMOClient $client
   * @param string    $data
   */
  private function read_packet($client, $data)
  {
    if($data === FALSE)
      return;

    $chars = str_split($data);
    $bytes = array();

    foreach($chars as $char)
      $bytes[] = ord($char);

    $byte_array    = new SimpleByteArray($bytes);
    $packet_length = $byte_array->read_short();

    $this->_packet_handler->read_packet($client, $byte_array);
  }
}