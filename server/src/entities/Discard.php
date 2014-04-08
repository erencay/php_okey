<?
/**
 * @property int    _direction
 * @property Tile[] _tiles
 */
class Discard
{
  private $_direction;
  private $_tiles;

  public function __construct($direction)
  {
    $this->_direction = $direction;
    $this->_tiles     = [];
  }

  /**
   * @return int
   */
  public function get_direction()
  {
    return $this->_direction;
  }

  /**
   * @param Tile $tile
   */
  public function add_tile($tile)
  {
    return array_push($this->_tiles, $tile);
  }

  /**
   * @return Tile
   */
  public function claim_tile()
  {
    return array_pop($this->_tiles);
  }

  /**
   * @return int
   */
  public function tiles_count()
  {
    return count($this->_tiles);
  }

  /**
   * @return Tile
   */
  public function get_last_tile()
  {
    return end($this->_tiles);
  }
}

class DiscardDirections extends Enum
{
  const SOUTH_EAST = 0x00;
  const NORTH_EAST = 0x01;
  const NORTH_WEST = 0x02;
  const SOUTH_WEST = 0x03;
}