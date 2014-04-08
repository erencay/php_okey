<?
/**
 * @property int _match_points
 * @property int _is_bonus_points_enabled
 * @property int _company_mode
 */
class UpdateTableSetting extends SendablePacket
{
  private $_match_points;
  private $_is_bonus_points_enabled;
  private $_is_company_mode_enabled;

  /**
   * @param int  $match_points
   * @param bool $is_bonus_points_enabled
   * @param bool $is_company_mode_enabled
   */
  public function __construct($match_points, $is_bonus_points_enabled, $is_company_mode_enabled)
  {
    $this->_match_points            = $match_points;
    $this->_is_bonus_points_enabled = $is_bonus_points_enabled;
    $this->_is_company_mode_enabled = $is_company_mode_enabled;
  }

  public function write()
  {
    $this->write_byte(ServerPacketHeader::UPDATE_TABLE_SETTING);
    $this->write_byte($this->_match_points);
    $this->write_boolean($this->_is_bonus_points_enabled);
    $this->write_boolean($this->_is_company_mode_enabled);
  }
}

