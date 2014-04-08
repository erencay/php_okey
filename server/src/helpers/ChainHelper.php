<?
class ChainHelper
{
  /**
   * @param Tile[] $tiles
   *
   * @return Tile[]
   */
  public static function get_chains($tiles)
  {
    $chunks = array();
    $i      = 0;

    foreach($tiles as $tile)
    {
      if(!$tile)
      {
        $i++;
        continue;
      }

      $chunks[$i][] = $tile;
    }

    return $chunks;
  }

  /**
   * @param Tile[] $tiles
   *
   * @return bool
   */
  private static function _is_valid_basic_chain($tiles)
  {
    count($tiles) > 2 || (count($tiles) == 1 && current($tiles)->is_joker());
  }

  /**
   * @param Tile[] $tiles
   *
   * @return bool
   */
  public static function is_valid_chain_of_same_numbers($tiles)
  {
    if(self::_is_valid_basic_chain($tiles))
      return FALSE;

    self::_remove_joker_from_chain($tiles);

    $colors = array();

    foreach($tiles as $tile)
      if($tile->get_number() != $tiles[0]->get_number())
        return FALSE;
      else
        array_push($colors, $tile->get_color());

    return count(array_unique($colors) != count($tiles));
  }

  /**
   * @param Tile[] $tiles
   *
   */
  private static function _remove_joker_from_chain(&$tiles)
  {
    foreach($tiles as $i => $tile)
      if($tile->is_joker())
        unset($tiles[$i]);
  }

  /**
   * @param Tile[] $tiles
   *
   * @return bool
   */
  public static function is_valid_chain_of_the_same_color($tiles)
  {
    if(!self::_is_valid_basic_chain($tiles))
      return FALSE;

    if(!ChainHelper::_is_ascending($tiles) || !ChainHelper::_is_descending($tiles))
      return FALSE;

    self::_remove_joker_from_chain($tiles);
    $colors = array();

    foreach($tiles as $tile)
      array_push($colors, $tile->get_color());

    return count(array_unique($colors)) == 1;
  }

  /**
   * @param Tile[] $tiles
   *
   * @return bool
   */
  private function _is_ascending($tiles)
  {
    $head = array_shift($tiles)->get_number();

    foreach($tiles as $tile)
      if($tile->is_joker())
        $head++;
      elseif($tile->get_number() + 1 == $head)
        $head++;
      else
        return FALSE;

    return TRUE;
  }

  /**
   * @param Tile[] $tiles
   *
   * @return bool
   */
  private function _is_descending($tiles)
  {
    $head = array_shift($tiles)->get_number();

    foreach($tiles as $tile)
      if($tile->is_joker())
        $head--;
      elseif($tile->get_number() - 1 == $head)
        $head--;
      else
        return FALSE;

    return TRUE;
  }

  /**
   * @param Tile[] $tiles
   *
   * @throws Exception
   */
  private function _is_valid_pair($tiles)
  {
    throw new Exception('To-Do');
  }
}

