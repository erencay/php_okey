<?
class PolicyFile extends SendablePacket
{
  private $_policy_file = '';

  function __construct()
  {
    $this->_policy_file .= '<cross-domain-policy>' . PHP_EOL;
    $this->_policy_file .= '<allow-access-from domain="*" to-ports="*" />' . PHP_EOL;
    $this->_policy_file .= '</cross-domain-policy>' . PHP_EOL;
  }

  public function write()
  {
    $this->write_string($this->_policy_file);
  }
}

