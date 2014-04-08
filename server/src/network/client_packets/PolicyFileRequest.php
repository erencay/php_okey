<?
class PolicyFileRequest extends ReceivablePacket
{
  public function implement()
  {
  }

  public function execute()
  {
    $this->get_client()->send(new PolicyFile(), FALSE);
  }
}

