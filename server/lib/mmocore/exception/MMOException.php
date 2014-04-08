<?
namespace MMOCore;

class MMOException extends \Exception
{
  /**
   * @param string     $message
   * @param int        $code
   * @param \Exception $previous
   */
  public function __construct($message, $code = 0, $previous = NULL)
  {
    parent::__construct($message, $code, $previous);
  }

  public function __toString()
  {
    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
  }
}