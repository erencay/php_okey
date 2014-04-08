<?
/**
 * @property string _username
 * @property string _password
 * @property string _password_confirm
 */
class RegisterRequest extends ReceivablePacket
{
  private $_username;
  private $_password;
  private $_password_confirm;

  public function implement()
  {
    $this->_username         = $this->read_string();
    $this->_password         = $this->read_string();
    $this->_password_confirm = $this->read_string();
  }

  public function execute()
  {
    $hash     = GenericHelper::generate_hash();
    $password = GenericHelper::crypt_password($this->_password, SALT, $hash);

    if($this->_create_player($this->_username, $password, $hash))
      $this->_create_player_succeed();
    else
      $this->get_client()->send(new SystemMessage(REGISTRATION_FAILED, SystemMessageLevels::ERROR));
  }

  private function _create_player_succeed()
  {
    $this->get_client()->send(new SystemMessage(REGISTRATION_SUCCEED, SystemMessageLevels::INFO));
    $this->get_client()->send(new ChangeStage(PlayerStages::LOGIN_FORM));
  }

  /**
   * @param string $username
   * @param string $password
   * @param string $hash
   *
   * @return bool
   */
  private function _create_player($username, $password, $hash)
  {
    $time      = time();
    $statement = Database::get_instance()->get_connection()->prepare("INSERT INTO players(username, password, hash, created_at, updated_at) VALUES (:username, :password, :hash, :created_at, :updated_at)");
    $statement->bindParam(':username', $username);
    $statement->bindParam(':password', $password);
    $statement->bindParam(':hash', $hash);
    $statement->bindParam(':created_at', $time);
    $statement->bindParam(':updated_at', $time);

    return $statement->execute();
  }

  /**
   * @param string $username
   *
   * @return int
   */
  public function _player_exists($username)
  {
    $statement = Database::get_instance()->get_connection()->prepare("SELECT COUNT(*) AS cnt FROM players WHERE username = :username");
    $statement->bindParam(':username', $username);
    $statement->execute();

    $player = $statement->fetchObject();

    return $player->cnt;
  }

  public function error()
  {
    if(!preg_match('/^[\w\d]{3,16}$/i', $this->_username))
      return INVALID_USERNAME;

    if(!preg_match('/^[\w\d]{6,16}$/i', $this->_password))
      return INVALID_PASSWORD;

    if($this->_password != $this->_password_confirm)
      return PASSWORDS_DOES_NOT_MATCH;

    if($this->_player_exists($this->_username))
      return THIS_USERNAME_ALREADY_REGISTERED;

    return parent::error();
  }
}

