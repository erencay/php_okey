<?
/**
 * @property int  _color
 * @property int  _number
 * @property bool _is_joker
 * @property bool _is_fake
 */
class Tile
{
  private $_color;
  private $_number;
  private $_is_joker;
  private $_is_fake;

  /**
   * @param int  $color
   * @param int  $number
   * @param bool $is_joker
   * @param bool $is_fake
   */
  public function __construct($color, $number, $is_joker, $is_fake)
  {
    $this->_color    = $color;
    $this->_number   = $number;
    $this->_is_joker = $is_joker;
    $this->_is_fake  = $is_fake;
  }

  /**
   * @return int
   */
  public function get_color()
  {
    return $this->_color;
  }

  /**
   * @return int
   */
  public function get_number()
  {
    return $this->_number;
  }

  /**
   * @return bool
   */
  public function is_joker()
  {
    return $this->_is_joker;
  }

  /**
   * @return bool
   */
  public function is_fake()
  {
    return $this->_is_fake;
  }
}

class TileColors extends Enum
{
  const BLACK  = 0x00;
  const RED    = 0x01;
  const BLUE   = 0x02;
  const YELLOW = 0x03;
}