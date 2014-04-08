<?
/**
 * @property string $_username
 * @property string $_password
 */
class LoginRequest extends ReceivablePacket
{
  private $_username;
  private $_password;

  public function implement()
  {
    $this->_username = $this->read_string();
    $this->_password = $this->read_string();
  }

  public function execute()
  {
    if(!$player_data = $this->_get_player_data())
      $this->get_client()->send(new SystemMessage(NO_SUCH_PLAYER_EXISTS, SystemMessageLevels::ERROR));
    elseif(GenericHelper::crypt_password($this->_password, SALT, $player_data->hash) != $player_data->password)
      $this->get_client()->send(new SystemMessage(YOU_ENTERED_A_WRONG_PASSWORD, SystemMessageLevels::ERROR));
    elseif(App::get_instance()->get_lobby()->get_player($player_data->id))
      $this->get_client()->send(new SystemMessage(THIS_ACCOUNT_ALREADY_IN_GAME, SystemMessageLevels::ERROR));
    else
      $this->_login_succeed($player_data);
  }

  /**
   * @param stdClass $player_data
   */
  private function _login_succeed($player_data)
  {
    $player = new Player($this->get_client(), $player_data->id, $player_data->username, $player_data->avatar, $player_data->point);
    $this->get_client()->set_player($player);
    $this->get_client()->send(new UpdateMyData($player->get_avatar(), $player->get_username(), $player->get_points(), $player->get_rank()));

    App::get_instance()->get_lobby()->add_player($player);
  }

  /**
   * @return stdClass
   */
  private function _get_player_data()
  {
    $statement = Database::get_instance()->get_connection()->prepare("SELECT * FROM players WHERE username = :username");
    $statement->bindParam(':username', $this->_username);
    $statement->execute();

    return $statement->fetchObject();
  }

  public function error()
  {
    if(!preg_match('/^[\w\d]{3,16}$/i', $this->_username))
      return INVALID_USERNAME;

    if(!preg_match('/^[\w\d]{6,16}$/i', $this->_password))
      return INVALID_PASSWORD;

    return parent::error();
  }
}

