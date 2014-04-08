<?
/**
 * @property int _match_points
 * @property int _is_bonus_points_enabled
 * @property int _company_mode
 */
class ChangeTableSettingRequest extends ReceivablePacket
{
  private $_match_points;
  private $_is_bonus_points_enabled;
  private $_is_company_mode_enabled;

  /**
   * @param int  $match_points
   * @param bool $is_bonus_points_enabled
   * @param bool $is_company_mode_enabled
   */
  public function implement()
  {
    $this->_match_points            = $this->read_byte();
    $this->_is_bonus_points_enabled = $this->read_bool();
    $this->_is_company_mode_enabled = $this->read_bool();
  }

  public function execute()
  {
    $this->get_player()->get_room()->set_match_points($this->_match_points);
    $this->get_player()->get_room()->set_bonus_points($this->_is_bonus_points_enabled);
    $this->get_player()->get_room()->set_company_mode($this->_is_company_mode_enabled);
  }

  public function error()
  {
    if(!$this->get_player()->get_room())
      return YOU_ARE_NOT_IN_A_ROOM;

    if($this->get_player()->get_room()->get_owner() != $this->get_player())
      return ONLY_ROOM_OWNER_CAN_CHANGE_A_SETTING;

    if($this->get_player()->get_room()->get_mode() != RoomMode::PREAPARING)
      return YOU_CAN_NOT_CHANGE_ROOM_SETTINGS_ONCE_GAME_STARTED;

    if(!RoomSettings::is_valid($this->_type))
      return UNDEFINED_ROOM_SETTING;

    return parent::error();
  }
}

