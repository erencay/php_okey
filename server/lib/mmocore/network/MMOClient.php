<?
namespace MMOCore;

/**
 * @property $_socket
 */
class MMOClient
{
  private $_socket;
  private $_id;

  public function __construct(&$socket)
  {
    $this->_socket = $socket;
    $this->_id     = uniqid();
  }

  /**
   * @return string
   */
  public function get_id()
  {
    return $this->_id;
  }

  /**
   * @return mixed
   */
  public function get_socket()
  {
    return $this->_socket;
  }

  /**
   * @return string
   */
  public function read()
  {
    return @socket_read($this->_socket, 1024, PHP_BINARY_READ);
  }

  /**
   * @param MMOSendablePacket $packet
   * @param bool              $calculate
   */
  public function send($packet, $calculate = TRUE)
  {
    $packet = clone $packet;
    $packet->write();

    if($calculate)
      $packet->calculate();

    \MMOCore\Logger::outgoing_packet($packet);

    @socket_write($this->_socket, $packet, strlen($packet));
    flush();
  }

  /**
   * @return MMOClient
   */
  public function close()
  {
    socket_close($this->_socket);
    unset($this->_socket);

    return $this;
  }
}