<?
/**
 * @property string _avatar
 */
class ChangeAvatarRequest extends ReceivablePacket
{
  private $_avatar;

  public function implement()
  {
    $this->_avatar = $this->read_string();
  }

  public function execute()
  {
    $this->get_player()->set_avatar($this->_avatar);
  }

  public function error()
  {
    if(!preg_match('/^[qazwsx]{1}$/', $this->_avatar))
      return INVALID_AVATAR;

    return parent::error();
  }
}

