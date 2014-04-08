<?
/*
 * @property Tile[] _tiles
 */
class Stack
{
  private $_tiles;

  /**
   * @return Tile
   */
  public function init_tiles()
  {
    $this->_tiles     = array();
    $indicator_color  = TileColors::get_values()[array_rand(TileColors::get_values())];
    $indicator_number = range(1, 13)[array_rand(range(1, 13))];

    foreach(TileColors::get_values() as $color)
      foreach(range(1, 13) as $num)
        $this->_tiles[] = new Tile($color, $num, ($color == $indicator_color && $indicator_number == 13 ? $num == 1 : $num == $indicator_number + 1), FALSE);

    $this->_tiles   = array_merge($this->_tiles, $this->_tiles);
    $this->_tiles[] = new Tile($indicator_color, $indicator_number == 13 ? 1 : $indicator_number + 1, FALSE, TRUE);
    $this->_tiles[] = new Tile($indicator_color, $indicator_number == 13 ? 1 : $indicator_number + 1, FALSE, TRUE);

    $indicator = $this->_tiles[$indicator_color * 13 + $indicator_number - 1];
    unset($this->_tiles[$indicator_color * 13 + $indicator_number - 1]);

    shuffle($this->_tiles);

    return $indicator;
  }

  /**
   * @return int
   */
  public function get_tiles_left()
  {
    return count($this->_tiles);
  }

  /**
   * @return Tile
   */
  public function get_last()
  {
    return array_pop($this->_tiles);
  }

  /**
   * @param int $length
   *
   * @return Tile[]
   */
  public function fetch_tiles($length)
  {
    return array_splice($this->_tiles, 0, $length);
  }
}