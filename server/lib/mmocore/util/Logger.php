<?
namespace MMOCore;

class Logger
{
  const INFO            = 'BILGI';
  const WARNING         = 'UYARI';
  const INCOMING_PACKET = 'GELEN PAKET';
  const OUTGOING_PACKET = 'GIDEN PAKET';
  const ERROR           = 'HATA';

  /**
   * @param string $message
   * @param string $level
   */
  public static function debug($message, $level = self::INFO)
  {
    echo sprintf('%s %s: %s' . PHP_EOL, date('[H:i:s d M Y]'), $level, $message);
  }

  public static function incoming_packet($class_name)
  {
    $reflector = new \ReflectionClass(get_class($class_name));
    self::debug(get_class($class_name) . ' -> ' . $reflector->getFileName(), self::INCOMING_PACKET);
  }

  public static function outgoing_packet($class_name)
  {
    $reflector = new \ReflectionClass(get_class($class_name));
    self::debug(get_class($class_name) . ' -> ' . $reflector->getFileName(), self::OUTGOING_PACKET);
  }
}