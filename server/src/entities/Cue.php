<?
/**
 * @property Seat   _seat
 * @property Tile[] _tiles
 */
class Cue
{
  private $_seat;
  private $_tiles;

  public function __construct($seat)
  {
    $this->_seat = $seat;

    $this->init_tiles();
  }

  private function init_tiles()
  {
    foreach(range(0, 1) as $line)
      foreach(range(0, 14) as $tile_holder)
        $this->_tiles[$line][$tile_holder] = NULL;
  }

  /**
   * @return Seat
   */
  public function get_seat()
  {
    return $this->_seat;
  }

  /**
   * @param int  $row
   * @param int  $col
   * @param Tile $tile
   */
  public function add_tile($row, $col, $tile)
  {
    $this->_tiles[$row][$col] = $tile;
    $this->_seat->get_player()->send(new AddTileToCue($row, $col, $tile->get_color(), $tile->get_number(), $tile->is_fake()));
  }

  /**
   * @param int $row
   * @param int $column
   *
   * @return Tile
   */
  public function remove_tile($row, $column)
  {
    $tile                        = $this->_tiles[$row][$column];
    $this->_tiles[$row][$column] = NULL;
    $this->_seat->get_player()->send(new RemoveTileFromCue($row, $column));

    return $tile;
  }

  /**
   * @return Tile[]
   */
  public function get_tiles()
  {
    return $this->_tiles;
  }

  /**
   * @param int $row
   * @param int $col
   *
   * @return Tile
   */
  public function get_tile_at($row, $col)
  {
    return $this->_tiles[$row][$col];
  }

  /**
   * @return bool
   */
  public function has_valid_hand()
  {
    $chains = ChainHelper::get_chains(array_merge($this->_tiles[0], array(NULL), $this->_tiles[1]));

    foreach($chains as $chain)
      if(!ChainHelper::is_valid_chain_of_same_numbers($chain) && !ChainHelper::is_valid_chain_of_the_same_color($chain))
        return FALSE;

    return TRUE;
  }
}