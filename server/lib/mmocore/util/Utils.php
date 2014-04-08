<?
namespace MMOCore;

class Utils
{
  public static function  import($path)
  {
    foreach(glob($path . '/*.php') as $file_name)
      require_once $file_name;
  }
}