<?
namespace MMOCore;

/**
 * @property int[] $_bytes
 * @property int   $_position
 */
class SimpleByteArray
{
  protected $_bytes;
  protected $_position = 0;

  /**
   * @param int[]|null $bytes
   */
  public function __construct($bytes = NULL)
  {
    if($bytes && !is_array($bytes))
      throw new SimpleByteArrayException('Sadece byte dizisi kullanabilirisiniz.');

    $this->_bytes = $bytes;
  }

  /**
   * @return int
   */
  public function get_position()
  {
    return $this->_position;
  }

  /**
   * @param int $position
   */
  public function set_position($position)
  {
    $this->_position = $position;
  }

  /**
   * @return \int[]
   */
  public function bytes()
  {
    return $this->_bytes;
  }

  /**
   * @return int
   */
  public function length()
  {
    return count($this->_bytes);
  }

  /**
   * @return int
   */
  public function bytes_available()
  {
    return $this->length() - $this->get_position();
  }

  /**
   * @param int $val
   */
  public function write_byte($val)
  {
    $this->_bytes[$this->_position++] = $val >> 0 & 0xFF;
  }

  /**
   * @param SimpleByteArray $source
   * @param int             $position
   * @param int             $limit
   *
   * @throws SimpleByteArrayException
   */
  public function write_bytes($source, $position, $limit)
  {
    if($position < 0)
      throw new SimpleByteArrayException("İmleç sıfırdan küçük olamaz. {$position}");

    if($limit < 0)
      throw new SimpleByteArrayException("Limit sıfırdan küçük olamaz. {$limit}");

    if($position > $source->length())
      throw new SimpleByteArrayException("İmleç dizin uzunluğundan büyük olamaz. {$position} : {$source->length()}");

    if($position + $limit > $source->length())
      throw new SimpleByteArrayException("İmleç ve limit toplamı dizinin uzunluğundan büyük olamaz. {$position} :{$limit} : {$source->length()}");

    $source->set_position($position);

    for($i = 0; $i < $limit; $i++)
      $this->write_byte($source->read_byte());
  }

  /**
   * @param int $val
   */
  public function write_boolean($val)
  {
    $this->_bytes[$this->_position++] = $val ? 0x01 : 0x00;
  }

  /**
   * @param int $val
   */
  public function write_short($val)
  {
    $this->_bytes[$this->_position++] = $val >> 8 & 0xFF;
    $this->_bytes[$this->_position++] = $val >> 0 & 0xFF;
  }

  /**
   * @param int $val
   */
  public function write_int($val)
  {
    $this->_bytes[$this->_position++] = $val >> 24;
    $this->_bytes[$this->_position++] = $val >> 16;
    $this->_bytes[$this->_position++] = $val >> 8;
    $this->_bytes[$this->_position++] = $val >> 0;
  }

  /**
   * @param string $val
   */
  public function write_string($val)
  {
    $val          = $val ? $val : '';
    $string_array = str_split($val);

    foreach($string_array as $letter)
      $this->write_byte(ord($letter));

    $this->write_byte(0x00);
  }

  /**
   * @return int
   */
  public function read_byte()
  {
    return $this->read_next() << 0;
  }

  /**
   * @return bool
   */
  public function read_bool()
  {
    return $this->read_next() << 0 == 0x01;
  }

  /**
   * @param SimpleByteArray $byte_array
   * @param int             $position
   * @param int             $limit
   *
   * @throws SimpleByteArrayException
   */
  public function read_bytes($byte_array, $position = 0, $limit = 0)
  {
    if($position < 0)
      throw new SimpleByteArrayException('İmleç sıfırdan küçük olamaz.');

    if($limit < 0)
      throw new SimpleByteArrayException('Limit sıfırdan küçük olamaz.');

    if($position > $byte_array->length())
      throw new SimpleByteArrayException("İmleç dizin uzunluğundan büyük olamaz. {$position} : {$byte_array->length()}");

    if($position + $limit > $byte_array->length())
      throw new SimpleByteArrayException("İmleç ve limit toplamı dizinin uzunluğundan büyük olamaz. {$position} :{$limit} : {$byte_array->length()}");

    $this->set_position($position);

    for($i = 0; $i < $limit; $i++)
      $byte_array->write_byte($this->read_byte());
  }

  /**
   * @return int
   */
  public function read_short()
  {
    $short = $this->read_next() << 8;
    $short += $this->read_next() << 0;

    return $short;
  }

  /**
   * @return int
   */
  public function read_int()
  {
    $int = $this->read_next() << 24;
    $int += $this->read_next() << 16;
    $int += $this->read_next() << 8;
    $int += $this->read_next() << 0;

    return $int;
  }

  /**
   * @return string
   */
  public function read_string()
  {
    $string = '';

    while($ord = $this->read_byte())
      $string .= chr($ord);

    return $string;
  }

  /**
   * @return int
   *
   * @throws SimpleByteArrayException
   */
  private function read_next()
  {
    if($this->get_position() > $this->length())
      throw new SimpleByteArrayException('Dizin sonuna ulaşildi.');

    return $this->_bytes[$this->_position++];
  }

  /**
   * @return string
   */
  public function __toString()
  {
    $original_position = $this->get_position();
    $out               = '';

    $this->set_position(0);

    while($this->bytes_available())
      $out .= pack('c', $this->read_byte());

    $this->set_position($original_position);

    return $out;
  }
}