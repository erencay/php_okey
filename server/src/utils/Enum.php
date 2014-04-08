<?php

abstract class Enum
{
  protected static $_instances = array();
  public $values;

  private function __construct()
  {
  }

  private function __clone()
  {
  }

  private function get_constants()
  {
    if(!empty($this->values))
      return $this->values;

    $reflection   = new ReflectionClass(get_class($this));
    $constants    = $reflection->getConstants();
    $this->values = array();

    foreach($constants as $constName => $constValue)
      $this->values[$constName] = $constValue;

    return $this->values;
  }

  public static function get_values()
  {
    $enum_name = get_called_class();

    if(!isset(self::$_instances[$enum_name]))
      self::$_instances[$enum_name] = new $enum_name;

    return self::$_instances[$enum_name]->get_constants();
  }

  public static function is_valid($value)
  {
    return in_array($value, call_user_func_array(array(get_called_class(), 'get_values'), array()));
  }
}


